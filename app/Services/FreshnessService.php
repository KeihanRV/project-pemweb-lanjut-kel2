<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FreshnessService
{
    public function check(string $absoluteImagePath): array
    {
        try {
            $response = Http::timeout(30)->attach(
                'file',
                file_get_contents($absoluteImagePath),
                basename($absoluteImagePath)
            )->post(config('services.ml.url'));

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('ML API returned non-success status', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return ['prediction' => 'unknown', 'status' => 'error'];
        } catch (\Exception $e) {
            Log::error('ML API request failed', [
                'message' => $e->getMessage(),
                'image' => $absoluteImagePath,
            ]);

            return ['prediction' => 'unknown', 'status' => 'error'];
        }
    }
}
