<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WeatherAlert;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function active(): JsonResponse
    {
        $alerts = WeatherAlert::active()
            ->with('location:id,name,slug')
            ->orderBy('severity', 'desc')
            ->orderBy('issued_at', 'desc')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $alerts,
            'count' => $alerts->count(),
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'location_id' => 'nullable|exists:locations,id',
            'type' => 'nullable|string',
            'severity' => 'nullable|in:info,warning,danger,extreme',
            'status' => 'nullable|in:active,expired,cancelled',
        ]);

        $alerts = WeatherAlert::with('location:id,name,slug')
            ->when($request->location_id, fn($q) => $q->where('location_id', $request->location_id))
            ->when($request->type, fn($q) => $q->where('alert_type', $request->type))
            ->when($request->severity, fn($q) => $q->where('severity', $request->severity))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderBy('issued_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return response()->json([
            'success' => true,
            'data' => $alerts,
        ]);
    }
}

