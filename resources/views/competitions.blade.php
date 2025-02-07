@extends('layouts.base')

@section('title', $title)

@section('content')
    <x-header
        title="Competitions"
        backUrl=""
        imgSrc=""
        imgAlt=""
    />

    <div class="grid grid-cols-2 gap-4 p-14 border">
        @foreach ($competitions as $competition)
            <a href="{{ route('competitions.competition', ['code' => $competition['code']]) }}" class="flex competitions-center space-x-4">
                <img src="{{ $competition['emblem'] }}" alt="{{ $competition['name'] }}" class="w-12 h-12 object-cover">
                <h1 class="text-lg">{{ $competition['name'] }}</h1>
            </a>
        @endforeach
    </div>
@endsection
