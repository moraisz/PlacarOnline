<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

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
        ])->get("{$this->baseUrl}/{$endpoint}", $query);

        if ($response->status() == 429) {
            abort(429);
        }

        return $response->json();
    }
}
