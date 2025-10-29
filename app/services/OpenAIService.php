<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    protected $apiKey;
    protected $apiUrl;
    protected $model;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
        $this->apiUrl = env('OPENAI_API_URL');
        $this->model = env('MODEL_NAME');
    }

    public function generateResponse($prompt)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, [
            'model' => $this->model,
            'input' => $prompt,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        // kalau error
        return [
            'error' => $response->body(),
        ];
    }
}
