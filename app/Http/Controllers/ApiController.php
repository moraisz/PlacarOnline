<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ApiController extends Controller {
    protected ApiService $apiService;

    public function __construct(ApiService $apiService) {
        $this->apiService = $apiService;
    }

    public function index(Request $request): View {
        $queryParams = $request->query();
        $data = $this->apiService->getData("competitions", $queryParams);

        $data["competitions"] = array_filter($data["competitions"], function ($competition) {
            return $competition["plan"] == "TIER_ONE";
        });
        $data["competitions"] = array_values($data["competitions"]);

        $data = [
            "data" => $data,
            "title" => "Index",
        ];

        return view("index", $data);
    }
}
