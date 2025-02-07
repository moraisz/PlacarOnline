@extends('layouts.base')

@section('title', $title)

@section('content')
    <x-header
        title="{{ $team['name'] }}"
        backUrl="{{ route('competitions.competition', ['code' => $competitionCode]) }}"
        imgSrc="{{ $team['crest'] }}"
        imgAlt="{{ $team['tla'] }}"
    />

    <x-section-title
        title="Proximos jogos da temporada"
    />
    @if ($futureTeamMatches)
        <x-card-vscroll>
            @foreach ($futureTeamMatches as $futureMatches)
                <x-card
                    date="{{ $futureMatches['utcDate'] }}"
                    homeTeam="{{ $futureMatches['homeTeam'] }}"
                    awayTeam="{{ $futureMatches['awayTeam'] }}"
                />
            @endforeach
        </x-card-vscroll>
    @else
        <x-not-found>
            Nenhum jogo encontrado para esta temporada.
        </x-not-found>
    @endif

    <x-section-title
        title="Ultimos jogos da temporada"
    />
    @if ($finishedTeamMatches)
        <x-card-vscroll>
            @foreach ($finishedTeamMatches as $finishedMatches)
                <x-card
                    date="{{ $finishedMatches['utcDate'] }}"
                    homeTeam="{{ $finishedMatches['homeTeam'] }}"
                    awayTeam="{{ $finishedMatches['awayTeam'] }}"
                    score="{{ $finishedMatches['score']['home'] }} X {{ $finishedMatches['score']['away'] }}"
                />
            @endforeach
        </x-card-vscroll>
    @else
        <x-not-found>
            Nenhum jogo encontrado para esta temporada.
        </x-not-found>
    @endif
@endsection
