<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    public function generateImage(string $prompt): string
    {
        $response = Http::withToken(env('GPT_API_KEY'))
            ->post('https://api.openai.com/v1/images/generations', [
                'model' => 'gpt-image-1', 
                'prompt' => $prompt.' generate the image',
                'n' => 1,
                'size' => '1024x1024'
            ]);

        // if ($response->failed()) {
        //     dd($response->json());
        // }

        return $response->json()['data'][0]['url'] ?? '';
    }

    public function generateTitleAndDescription(string $prompt): array
    {
        $response = Http::withToken(env('GPT_API_KEY'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a creative e-commerce product copywriter.'],
                    ['role' => 'user', 'content' => "Write a short catchy hoodie product title and a 2-sentence description for: {$prompt}"]
                ],
                'temperature' => 0.8
            ]);

        $text = $response->json()['choices'][0]['message']['content'] ?? '';
        // dd($text);
        $lines = explode("\n", trim($text));
        $title = trim($lines[0]);
        $description = trim(implode(" ", array_slice($lines, 1)));
        
        return [$title, $description];
    }
}
