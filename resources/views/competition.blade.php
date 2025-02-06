@extends('layouts.base')

@section('title', $title)

@section('content')
    <div>
        <img src="{{ $competition['emblem'] }}" alt="{{ $competition['code'] }}" class="w-12 h-12 object-cover">
        <h3>{{ $competition['name'] }}</h3>
    </div>

    <div>
        <h2>Proximos jogos do mês</h2>
        @foreach ($futureCompetitionMatches as $futureMatches)
            <div class="border border-indigo-500">
                <h3>{{ $futureMatches['homeTeam'] }} X {{ $futureMatches['awayTeam'] }}</h3>
                {{ $futureMatches['utcDate'] }}
            </div>
        @endforeach

        <h2>Ultimos jogos do mês</h2>
        @foreach ($pastCompetitionMatches as $pastMatches)
            <div class="border border-sky-500">
                <h3>{{ $pastMatches['homeTeam'] }} X {{ $pastMatches['awayTeam'] }}</h3>
                {{ $pastMatches['score']['home'] }} X {{ $pastMatches['score']['away'] }}
                {{ $pastMatches['utcDate'] }}
            </div>
        @endforeach

        <h2>Times da competition</h2>
        @foreach ($teams as $team)
            <div class="border border-red-500">
                <a href="">
                    <img src="{{ $team['crest'] }}" alt="{{ $team['name'] }}">
                    {{ $team['name'] }}
                </a>
            </div>
        @endforeach
    </div>
@endsection
