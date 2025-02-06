<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Placar Online - {{ $title }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        @foreach ($data["competitions"] as $item)
            <div class="flex items-center space-x-4">
                <img src="{{ $item["emblem"] }}" alt="{{ $item["name"] }}" class="w-12 h-12 object-cover">
                <h3>{{ $item["name"] }}</h3>
            </div>
        @endforeach
    </body>
</html>
