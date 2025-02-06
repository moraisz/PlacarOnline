@extends('layouts.base')

@section('title', $title)

@section('content')
    @foreach ($competitions as $competition)
        <a href="{{ route('competitions.competition', ['code' => $competition['code']]) }}" class="flex competitions-center space-x-4">
            <img src="{{ $competition['emblem'] }}" alt="{{ $competition['name'] }}" class="w-12 h-12 object-cover">
            <h3>{{ $competition['name'] }}</h3>
        </a>
    @endforeach
@endsection
