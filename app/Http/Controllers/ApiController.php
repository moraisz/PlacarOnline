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

    public function competition($code): View {
        // dados da competition
        $competition = $this->apiService->getData("competitions/{$code}");

        // filtra para obter somente o necessario
        $filteredCompetition = [
            'id' => $competition['id'],
            'name' => $competition['name'],
            'code' => $competition['code'],
            'emblem' => $competition['emblem'],
        ];

        // variaveis importantes para buscar matches
        $today = (new DateTime())->format("Y-m-d");
        $lastDayMonth = (new DateTime("last day of this month"))->format("Y-m-d");
        $firstDayMonth = (new DateTime("first day of this month"))->format("Y-m-d");

        // busca proximas matches da competition dentro do mes atual
        $queryFutureParams = [
            "dateFrom" => $today,
            "dateTo" => $lastDayMonth,
        ];
        $futureCompetitionMatches = $this->apiService->getData("competitions/{$code}/matches", $queryFutureParams);

        // formatar a data para um visual mais agradavel
        foreach ($futureCompetitionMatches["matches"] as &$future_matches) {
            $future_matches["utcDate"] = Carbon::parse($future_matches["utcDate"])->format("d/m/Y \à\s H:i");
        }

        $filteredFutureMatches = collect($futureCompetitionMatches['matches'])->map(function ($match) {
            return [
                'utcDate' => $match['utcDate'],
                'homeTeam' => $match['homeTeam']['name'],
                'awayTeam' => $match['awayTeam']['name'],
            ];
        })->toArray();

        // busca matches passadas da competition dentro do mes atual
        $queryPastParams = [
            "dateFrom" => $firstDayMonth,
            "dateTo" => $today,
        ];
        $pastCompetitionMatches = $this->apiService->getData("competitions/{$code}/matches", $queryPastParams);

        // formatar a data para um visual mais agradavel
        foreach ($pastCompetitionMatches["matches"] as &$pastMatches) {
            $pastMatches["utcDate"] = Carbon::parse($pastMatches["utcDate"])->format("d/m/Y \à\s H:i");
        }

        $filteredPastMatches = collect($pastCompetitionMatches['matches'])->map(function ($match) {
            return [
                'utcDate' => $match['utcDate'],
                'homeTeam' => $match['homeTeam']['name'],
                'awayTeam' => $match['awayTeam']['name'],
                'score' => $match['score']['fullTime'] ?? null, // Evita erro caso não tenha esse campo
            ];
        })->toArray();

        // busca dados dos times da competition
        $teams = $this->apiService->getData("competitions/{$code}/teams");

        $filteredTeams = collect($teams['teams'])->map(function ($team) {
            return [
                'id' => $team['id'],
                'name' => $team['name'],
                'crest' => $team['crest'],
            ];
        })->toArray();

        $data = [
            "title" => "Competition {$code}",
            "competition" => $filteredCompetition,
            "futureCompetitionMatches" => $filteredFutureMatches,
            "pastCompetitionMatches" => $filteredPastMatches,
            "teams" => $filteredTeams,
        ];

        return view("competition", $data);
    }
}
