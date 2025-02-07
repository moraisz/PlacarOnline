@extends('layouts.base')

@section('title', $title)

@section('content')
    <x-header
        title="{{ $competition['name'] }}"
        backUrl="{{ route('competitions') }}"
        imgSrc="{{ $competition['emblem'] }}"
        imgAlt="{{ $competition['code'] }}"
    />

    <h1 class="text-center text-3xl mt-6">Proximos jogos do mês</h1>
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
        <div class="flex justify-center items-center mt-6">
            <p class="text-gray-500 text-lg font-semibold bg-gray-100 p-4 rounded-lg shadow-md">
                Nenhum jogo encontrado para este período.
            </p>
        </div>
    @endif

    <h1 class="text-center text-3xl mt-6">Ultimos jogos do mês</h1>
    @if ($pastCompetitionMatches)
        <x-card-vscroll>
            @foreach ($pastCompetitionMatches as $pastMatches)
                <x-card
                    date="{{ $pastMatches['utcDate'] }}"
                    homeTeam="{{ $pastMatches['homeTeam'] }}"
                    awayTeam="{{ $pastMatches['awayTeam'] }}"
                    score="{{ $pastMatches['score']['home'] }} X {{ $pastMatches['score']['away'] }}"
                />
            @endforeach
        </x-card-vscroll>
    @else
        <div class="flex justify-center items-center mt-6">
            <p class="text-gray-500 text-lg font-semibold bg-gray-100 p-4 rounded-lg shadow-md">
                Nenhum jogo encontrado para este período.
            </p>
        </div>
    @endif

    <h1 class="text-center text-3xl mt-6">Times da competition</h1>
    @if ($teams)
        <div class="grid grid-cols-2 gap-4 p-14 border">
            @foreach ($teams as $team)
                <a href="" class="flex competitions-center space-x-4">
                    <img src="{{ $team['crest'] }}" alt="{{ $team['name'] }}" class="w-12 h-12 object-cover">
                    <h1 class="text-lg">{{ $team['name'] }}</h1>
                </a>
            @endforeach
        </div>
    @else
        <div class="flex justify-center items-center mt-6">
            <p class="text-gray-500 text-lg font-semibold bg-gray-100 p-4 rounded-lg shadow-md">
                Nenhum time encontrado para esta temporada.
            </p>
        </div>
    @endif

@endsection
