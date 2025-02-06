<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ApiController extends Controller {
    protected ApiService $apiService;

    public function __construct(ApiService $apiService) {
        $this->apiService = $apiService;
    }

    public function competitions(Request $request): View {
        $queryParams = $request->query();
        $data = $this->apiService->getData("competitions", $queryParams);
        $competitions = $data["competitions"];

        $competitions = array_filter($competitions, function ($competition) {
            return $competition["plan"] == "TIER_ONE";
        });
        $competitions = array_values($competitions);

        $data = [
            "competitions" => $competitions,
            "title" => "Competitions",
        ];

        return view("competitions", $data);
    }

    public function competition(Request $request, $code): View {
        // proximos jogos do mes (nao tem query)
        $today = (new DateTime())->format('Y-m-d');
        $lastDayMonth = (new DateTime('last day of this month'))->format('Y-m-d');
        $firstDayMonth = (new DateTime('first day of this month'))->format('Y-m-d');

        $queryFutureParams = [
            "dateFrom" => $today,
            "dateTo" => $lastDayMonth,
        ];
        $future_competition_matches = $this->apiService->getData("competitions/{$code}/matches", $queryFutureParams);

        foreach ($future_competition_matches["matches"] as &$future_matches) {
            $future_matches['utcDate'] = Carbon::parse($future_matches['utcDate'])->format('d/m/Y \à\s H:i');
        }

        // ToDo: ultimos jogos do mes (possibilidade de query)
        $queryPastParams = [
            "dateFrom" => $firstDayMonth,
            "dateTo" => $today,
        ];
        $past_competition_matches = $this->apiService->getData("competitions/{$code}/matches", $queryPastParams);

        foreach ($past_competition_matches["matches"] as &$past_matches) {
            $past_matches['utcDate'] = Carbon::parse($past_matches['utcDate'])->format('d/m/Y \à\s H:i');
        }

        $competition = $future_competition_matches["competition"];

        $data = [
            "competition" => $competition,
            "future_competition_matches" => $future_competition_matches,
            "past_competition_matches" => $past_competition_matches,
            "title" => "Competition {$code}",
        ];

        /*dd($data);*/
        return view('competition', $data);
    }
}
