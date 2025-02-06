<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class ApiService {

    protected string $baseUrl;
    protected string $apiKey;

    public function __construct() {
        $this->baseUrl = config('services.api.base_url');
        $this->apiKey = config('services.api.api_key');
    }

    public function getData(string $endpoint, array $query = []) {
        $response = Http::withHeaders([
            'X-Auth-Token' => $this->apiKey,
            'Accept' => 'application/json',
        ])->retry(5, 1000)->get( // tenta 5 vezes a cada 1 segundo, api externa com erro de "Invalid Token"
            "{$this->baseUrl}/{$endpoint}",
            $query
        );

        return $response->json();
    }
}
