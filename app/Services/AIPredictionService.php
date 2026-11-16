<?php

namespace App\Services;

use App\Models\MachineLearningModel;
use App\Models\WeatherAccuracy;
use App\Models\WeatherCorrection;
use App\Models\WeatherHistory;
use App\Models\WeatherPrediction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AIPredictionService
{
    /**
     * Calculate accuracy metrics for predictions vs actual
     */
    public function evaluateAccuracy(): void
    {
        // Get predictions that have actual data but haven't been evaluated
        $predictions = WeatherPrediction::whereHas('actuals')
            ->whereDoesntHave('accuracies')
            ->where('forecast_for', '<=', now())
            ->limit(100)
            ->get();

        foreach ($predictions as $prediction) {
            $actual = $prediction->actuals()->latest('observed_at')->first();
            if (!$actual) continue;

            $tempDiff = ($prediction->temperature && $actual->temperature)
                ? abs($prediction->temperature - $actual->temperature)
                : null;

            $weatherMatch = ($prediction->weather_main && $actual->weather_main)
                ? ($prediction->weather_main === $actual->weather_main)
                : null;

            // Determine status
            $status = 'partial';
            if ($tempDiff !== null && $weatherMatch !== null) {
                $status = ($tempDiff <= 2 && $weatherMatch) ? 'correct' : 'incorrect';
            }

            // Calculate accuracy score (0-100)
            $score = 0;
            if ($tempDiff !== null) {
                $tempScore = max(0, 100 - ($tempDiff * 10));
                $score += $tempScore * 0.6; // 60% weight on temperature
            }
            if ($weatherMatch !== null) {
                $score += $weatherMatch ? 40 : 0; // 40% weight on weather condition
            }

            WeatherAccuracy::create([
                'location_id' => $prediction->location_id,
                'prediction_id' => $prediction->id,
                'actual_id' => $actual->id,
                'evaluated_at' => now(),
                'temp_predicted' => $prediction->temperature,
                'temp_actual' => $actual->temperature,
                'temp_difference' => $tempDiff,
                'weather_predicted' => $prediction->weather_main,
                'weather_actual_condition' => $actual->weather_main,
                'weather_match' => $weatherMatch,
                'humidity_predicted' => $prediction->humidity,
                'humidity_actual' => $actual->humidity,
                'wind_speed_predicted' => $prediction->wind_speed,
                'wind_speed_actual' => $actual->wind_speed,
                'pressure_predicted' => $prediction->pressure,
                'pressure_actual' => $actual->pressure,
                'status' => $status,
                'accuracy_score' => round($score, 2),
            ]);
        }
    }

    /**
     * Generate AI corrections based on historical patterns
     */
    public function generateCorrections(): void
    {
        // Get recent predictions that need correction
        $predictions = WeatherPrediction::where('forecast_for', '>=', now())
            ->where('forecast_for', '<=', now()->addHours(48))
            ->whereDoesntHave('corrections')
            ->limit(50)
            ->get();

        foreach ($predictions as $prediction) {
            // Analyze historical accuracy for this location and time
            $historicalErrors = WeatherAccuracy::where('location_id', $prediction->location_id)
                ->where('temp_predicted', '>', 0)
                ->orderBy('evaluated_at', 'desc')
                ->limit(30)
                ->get();

            if ($historicalErrors->count() < 5) continue;

            // Calculate average error pattern
            $avgTempError = $historicalErrors->avg('temp_difference');
            $correctedTemp = $prediction->temperature + $avgTempError;

            // Calculate confidence based on consistency of errors
            $stdDev = $historicalErrors->std(fn($item) => $item->temp_difference);
            $confidence = max(0, min(100, 100 - ($stdDev * 20)));

            if ($confidence < 30) continue; // Skip if confidence too low

            // Determine corrected weather condition
            $correctedWeather = $prediction->weather_main;
            $mostAccurate = WeatherAccuracy::where('location_id', $prediction->location_id)
                ->where('weather_predicted', $prediction->weather_main)
                ->whereNotNull('weather_match')
                ->orderBy('evaluated_at', 'desc')
                ->limit(20)
                ->get();

            if ($mostAccurate->count() > 5) {
                $matchRate = $mostAccurate->where('weather_match', true)->count() / $mostAccurate->count();
                if ($matchRate < 0.5) {
                    // Find most common actual weather for this prediction
                    $commonActual = WeatherAccuracy::where('location_id', $prediction->location_id)
                        ->where('weather_predicted', $prediction->weather_main)
                        ->select('weather_actual_condition', DB::raw('COUNT(*) as count'))
                        ->groupBy('weather_actual_condition')
                        ->orderByDesc('count')
                        ->first();

                    if ($commonActual && $commonActual->weather_actual_condition) {
                        $correctedWeather = $commonActual->weather_actual_condition;
                    }
                }
            }

            WeatherCorrection::create([
                'location_id' => $prediction->location_id,
                'prediction_id' => $prediction->id,
                'original_temperature' => $prediction->temperature,
                'original_weather' => $prediction->weather_main,
                'corrected_temperature' => round($correctedTemp, 1),
                'corrected_weather' => $correctedWeather,
                'correction_factor' => $avgTempError,
                'correction_reason' => 'Berdasarkan analisis historis ' . $historicalErrors->count() . ' data terakhir',
                'confidence_score' => round($confidence, 2),
                'model_used' => 'ai_correction_engine_v1',
                'model_accuracy' => round(100 - ($stdDev * 10), 2),
                'is_applied' => false,
            ]);
        }
    }

    /**
     * Get overall accuracy statistics
     */
    public function getAccuracyStats(): array
    {
        $stats = WeatherAccuracy::select(
            DB::raw('AVG(accuracy_score) as accuracy'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "correct" THEN 1 ELSE 0 END) as correct'),
            DB::raw('SUM(CASE WHEN status = "incorrect" THEN 1 ELSE 0 END) as incorrect'),
            DB::raw('AVG(temp_difference) as avg_error'),
            DB::raw('AVG(ABS(temp_difference)) as mae'),
        )->first();

        return [
            'accuracy' => round($stats->accuracy ?? 0, 2),
            'total_evaluations' => $stats->total ?? 0,
            'correct' => $stats->correct ?? 0,
            'incorrect' => $stats->incorrect ?? 0,
            'avg_error' => round($stats->avg_error ?? 0, 2),
            'mae' => round($stats->mae ?? 0, 2),
        ];
    }
}

