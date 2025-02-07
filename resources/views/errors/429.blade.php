@extends('layouts.base')

@section('title', 'Muitas Requisições')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen text-center">
        <h1 class="text-5xl font-bold text-red-600">429</h1>
        <p class="text-xl mt-4">Você atingiu o limite de requisições.</p>
        <p class="text-gray-500">Aguarde alguns segundos e tente novamente.</p>
    </div>
@endsection

