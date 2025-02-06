@extends('layouts.base')

@section('title', $title)

@section('content')
    <div>
        <img src="{{ $competition['emblem'] }}" alt="{{ $competition['code'] }}" class="w-12 h-12 object-cover">
        <h3>{{ $competition['name'] }}</h3>
    </div>
    <div>
        <h2>Proximos jogos do mês</h2>
        @foreach ($future_competition_matches['matches'] as $future_matches)
            <div class="border border-indigo-500">
                <h3>{{ $future_matches['homeTeam']['name'] }} X {{ $future_matches['awayTeam']['name'] }}</h3>
                {{ $future_matches['utcDate'] }}
            </div>
        @endforeach

        <h2>Ultimos jogos do mês</h2>
        @foreach ($past_competition_matches['matches'] as $past_matches)
            {{--@dd($past_matches)--}}
            <div class="border border-sky-500">
                <h3>{{ $past_matches['homeTeam']['name'] }} X {{ $past_matches['awayTeam']['name'] }}</h3>
                {{ $past_matches['score']['fullTime']['home'] }} X {{ $past_matches['score']['fullTime']['away'] }}
                {{ $past_matches['utcDate'] }}
            </div>
        @endforeach
    </div>
@endsection
