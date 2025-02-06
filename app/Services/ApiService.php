<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class ApiService {

    protected string $baseUrl;

    public function __construct() {
        $this->baseUrl = config('services.api.base_url');
    }

    public function getData(string $endpoint, array $query = []) {
        $response = Http::get("{$this->baseUrl}/{$endpoint}", $query);
        return $response->json();
    }
}
