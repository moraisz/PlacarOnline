<header class="bg-blue-600 text-white p-4 flex items-center relative">
    @if ($backUrl)
        <a href="{{ $backUrl }}" class="absolute left-4 flex items-center text-white hover:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Voltar
        </a>
    @endif

<div class="gap-2 flex items-center mx-auto space-x-3">
    @if ($imgSrc)
        <img src="{{ $imgSrc }}" alt="{{ $imgAlt }}" class="w-14 h-14 object-cover rounded-full">
    @endif
    <h1 class="text-xl font-bold">{{ $title }}</h1>
</header>

