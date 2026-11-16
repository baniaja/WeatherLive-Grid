<?php

namespace App\Jobs;

use App\Services\AIPredictionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EvaluateAccuracy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;

    public function __construct()
    {
        //
    }

    public function handle(AIPredictionService $aiService): void
    {
        try {
            Log::info('Starting accuracy evaluation...');

            // Evaluate prediction accuracy
            $aiService->evaluateAccuracy();

            // Generate corrections based on patterns
            $aiService->generateCorrections();

            $stats = $aiService->getAccuracyStats();

            Log::info("Accuracy evaluation completed. Stats: " . json_encode($stats));
        } catch (\Exception $e) {
            Log::error('Accuracy evaluation failed: ' . $e->getMessage());
            $this->fail($e);
        }
    }
}

