<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PrintfulService
{
    private $baseUrl = 'https://api.printful.com';

    private $variantMap = [
        'hoodie' => 4011, // Gildan 18500 Unisex Hoodie
        'tshirt' => 71,   // Bella+Canvas 3001 Unisex T-Shirt
        'mug'    => 1321  // 11oz White Mug
    ];

    public function uploadImage(string $imageUrl): int
    {
        $response = Http::withToken(env('PRINT_API_KEY'))
            ->post($this->baseUrl.'/files', [
                'url' => $imageUrl
            ]);

        return $response->json()['result']['id'] ?? 0;
    }

    public function generateMockup(int $fileId, string $productType): ?string
    {
        $variantId = $this->variantMap[$productType] ?? $this->variantMap['hoodie'];

        $response = Http::withToken(env('PRINT_API_KEY'))
            ->post($this->baseUrl."/mockup-generator/create-task/{$variantId}", [
                'variant_ids' => [$variantId],
                'files' => [
                    ['placement' => 'front', 'image_id' => $fileId]
                ]
            ]);

        $taskKey = $response->json()['result']['task_key'] ?? null;
        if (!$taskKey) return null;

        for ($i = 0; $i < 10; $i++) {
            sleep(2);
            $check = Http::withToken(env('PRINT_API_KEY'))
                ->get($this->baseUrl.'/mockup-generator/task', [
                    'task_key' => $taskKey
                ])->json();

            if (($check['result']['status'] ?? '') === 'completed') {
                return $check['result']['mockups'][0]['mockup_url'] ?? null;
            }
        }
        return null;
    }
}