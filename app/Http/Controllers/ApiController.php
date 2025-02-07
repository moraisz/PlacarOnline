<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class ApiController extends Controller {
    protected ApiService $apiService;

    public function __construct(ApiService $apiService) {
        $this->apiService = $apiService;
    }

    public function competitions(): View {
        $data = $this->apiService->getData("competitions");
        $competitions = $data["competitions"];

        // filtra somente o plano gratuito da api
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

    public function competition(string $code): View {
        $competitionMatches = $this->apiService->getData("competitions/{$code}/matches");

        // formata a data para um visual mais agradavel
        foreach ($competitionMatches["matches"] as &$match) {
            $match["utcDate"] = Carbon::parse($match["utcDate"])->format("d/m/Y \à\s H:i");
        }

        $futureCompetitionMatches = [];
        $finishedCompetitionMatches = [];
        foreach ($competitionMatches['matches'] as $match) {
            if ($match['status'] == "FINISHED") {
               $finishedCompetitionMatches[] = $match;
            } else {
               $futureCompetitionMatches[] = $match;
            }
        }

        $filteredFinishedMatches = collect($finishedCompetitionMatches)->map(function ($match) {
            return [
                'utcDate' => $match['utcDate'],
                'homeTeam' => $match['homeTeam']['name'],
                'awayTeam' => $match['awayTeam']['name'],
                'score' => $match['score']['fullTime'] ?? null, // Evita erro caso não tenha esse campo
            ];
        })->toArray();

        $filteredFutureMatches = collect($futureCompetitionMatches)->map(function ($match) {
            return [
                'utcDate' => $match['utcDate'],
                'homeTeam' => $match['homeTeam']['name'],
                'awayTeam' => $match['awayTeam']['name'],
                'score' => $match['score']['fullTime'] ?? null, // Evita erro caso não tenha esse campo
            ];
        })->toArray();

        // dados da competition
        $competition = $competitionMatches["competition"];

        // filtra para obter somente o necessario
        $filteredCompetition = [
            'id' => $competition['id'],
            'name' => $competition['name'],
            'code' => $competition['code'],
            'emblem' => $competition['emblem'],
        ];

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
            "title" => "{$code}",
            "competition" => $filteredCompetition,
            "futureCompetitionMatches" => $filteredFutureMatches,
            "finishedCompetitionMatches" => $filteredFinishedMatches,
            "teams" => $filteredTeams,
        ];

        return view("competition", $data);
    }

    public function team(string $competitionCode, string $id): View {
        $team = $this->apiService->getData("teams/{$id}");
        $teamMatches = $this->apiService->getData("teams/{$id}/matches");

        foreach ($teamMatches["matches"] as &$match) {
            $match["utcDate"] = Carbon::parse($match["utcDate"])->format("d/m/Y \à\s H:i");
        }

        $futureTeamMatches = [];
        $finishedTeamMatches = [];
        foreach ($teamMatches['matches'] as $match) {
            if ($match['status'] == "FINISHED") {
               $finishedTeamMatches[] = $match;
            } else {
               $futureTeamMatches[] = $match;
            }
        }

        $filteredFinishedMatches = collect($finishedTeamMatches)->map(function ($match) {
            return [
                'utcDate' => $match['utcDate'],
                'homeTeam' => $match['homeTeam']['name'],
                'awayTeam' => $match['awayTeam']['name'],
                'score' => $match['score']['fullTime'] ?? null, // Evita erro caso não tenha esse campo
            ];
        })->toArray();

        $filteredFutureMatches = collect($futureTeamMatches)->map(function ($match) {
            return [
                'utcDate' => $match['utcDate'],
                'homeTeam' => $match['homeTeam']['name'],
                'awayTeam' => $match['awayTeam']['name'],
                'score' => $match['score']['fullTime'] ?? null, // Evita erro caso não tenha esse campo
            ];
        })->toArray();

        $data = [
            "competitionCode" => $competitionCode,
            "title" => $team["shortName"],
            "team" => $team,
            "futureTeamMatches" => $filteredFutureMatches,
            "finishedTeamMatches" => $filteredFinishedMatches,
        ];

        return view("team", $data);
    }
}
