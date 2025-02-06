<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller {
    protected ApiService $apiService;

    public function __construct(ApiService $apiService) {
        $this->apiService = $apiService;
    }

    public function index(Request $request): JsonResponse {
        $queryParams = $request->query();
        $data = $this->apiService->getData('competitions', $queryParams);
        return response()->json($data);
    }
}
