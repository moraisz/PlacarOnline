@props(['score' => null, 'date', 'homeTeam', 'awayTeam'])

<div class="bg-white shadow-md rounded-lg p-4 w-64 flex-shrink-0">
    <h3 class="text-lg font-bold text-center">{{ $date }}</h3>
    <div class="flex flex-col items-center mt-2">
        <span class="text-gray-700">{{ $homeTeam }}</span>
        <span class="font-bold">vs</span>
        <span class="text-gray-700">{{ $awayTeam }}</span>
        @if ($score)
            <span class="text-gray-700">{{ $score }}</span>
        @endif
    </div>
</div>
