<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WeatherAccuracy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccuracyController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'location_id' => 'nullable|exists:locations,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
        ]);

        $records = WeatherAccuracy::with(['location:id,name', 'prediction:id,forecast_for'])
            ->when($request->location_id, fn($q) => $q->where('location_id', $request->location_id))
            ->when($request->date_from, fn($q) => $q->whereDate('evaluated_at', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->whereDate('evaluated_at', '<=', $request->date_to))
            ->orderBy('evaluated_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return response()->json([
            'success' => true,
            'data' => $records,
        ]);
    }

    public function stats(Request $request): JsonResponse
    {
        $request->validate([
            'location_id' => 'nullable|exists:locations,id',
            'period' => 'nullable|in:7,14,30,90',
        ]);

        $days = $request->period ?? 30;
        $since = now()->subDays($days);

        $driver = DB::connection()->getDriverName();

        $query = WeatherAccuracy::where('evaluated_at', '>=', $since);
        if ($request->location_id) {
            $query->where('location_id', $request->location_id);
        }

        // Build aggregate query safe for all supported DB drivers.
        $selectExpressions = [
            DB::raw('AVG(accuracy_score) as accuracy'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "correct" THEN 1 ELSE 0 END) as correct'),
            DB::raw('SUM(CASE WHEN status = "incorrect" THEN 1 ELSE 0 END) as incorrect'),
            DB::raw('AVG(temp_difference) as avg_temp_error'),
            DB::raw('AVG(ABS(temp_difference)) as mae'),
        ];

        // SQRT/POWER is not available in SQLite; compute RMSE in PHP for SQLite.
        if ($driver === 'sqlite') {
            $rows = (clone $query)->select('temp_difference')->get();

            $stats = (clone $query)->select($selectExpressions)->first();

            $rmse = null;
            $totalDiff = 0;
            $countDiff = 0;
            foreach ($rows as $row) {
                if ($row->temp_difference === null) {
                    continue;
                }
                $totalDiff += $row->temp_difference * $row->temp_difference;
                $countDiff++;
            }
            if ($countDiff > 0) {
                $rmse = sqrt($totalDiff / $countDiff);
            }

            $stats->rmse = $rmse;
        } else {
            // MySQL & PostgreSQL both support SQRT()
            $selectExpressions[] = DB::raw('SQRT(AVG(temp_difference * temp_difference)) as rmse');

            $stats = (clone $query)->select($selectExpressions)->first();
        }

        // Daily accuracy trend
        $dailyTrend = WeatherAccuracy::where('evaluated_at', '>=', $since)
            ->when($request->location_id, fn($q) => $q->where('location_id', $request->location_id))
            ->select(
                DB::raw('DATE(evaluated_at) as date'),
                DB::raw('AVG(accuracy_score) as avg_accuracy'),
                DB::raw('COUNT(*) as evaluations')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'overall' => $stats,
                'daily_trend' => $dailyTrend,
            ],
        ]);
    }
}

