@extends('layouts.base')

@section('title', $title)

@section('content')
    <x-header
        title="{{ $competition['name'] }}"
        backUrl="{{ route('competitions') }}"
        imgSrc="{{ $competition['emblem'] }}"
        imgAlt="{{ $competition['code'] }}"
    />

    <x-section-title
        title="Proximos jogos da temporada"
    />
    @if ($futureCompetitionMatches)
        <x-card-vscroll>
            @foreach ($futureCompetitionMatches as $futureMatches)
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
    @if ($finishedCompetitionMatches)
        <x-card-vscroll>
            @foreach ($finishedCompetitionMatches as $finishedMatches)
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

    <x-section-title
        title="Times da {{ $competition['name'] }}"
    />
    @if ($teams)
        <div class="grid grid-cols-3 gap-4 p-14 border">
            @foreach ($teams as $team)
                <a href="{{ route('team.team', ['id' => $team['id'], 'competitionCode' => $competition['code']]) }}" class="flex competitions-center space-x-4">
                    <img src="{{ $team['crest'] }}" alt="{{ $team['name'] }}" class="w-12 h-12 object-cover">
                    <h1 class="text-lg">{{ $team['name'] }}</h1>
                </a>
            @endforeach
        </div>
    @else
        <x-not-found>
            Nenhum time encontrado para esta temporada.
        </x-not-found>
    @endif
@endsection
