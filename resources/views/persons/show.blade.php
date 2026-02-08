<x-app-layout>
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">{{ $person->label_en }}</h1>
                    @if ($person->legendary)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            Legendary
                        </span>
                    @endif
                </div>
                @auth
                    <a href="{{ route('persons.edit', $person) }}" class="inline-flex items-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-6 text-[#313647]">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span class="font-medium">{{ $person->identifier }}</span>
                </div>
                @if ($person->birth_year || $person->death_year)
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">
                            @if ($person->birth_year)
                                {{ $person->birth_year_uncertain ? 'ca. ' : '' }}{{ $person->birth_year < 0 ? abs($person->birth_year) . ' BCE' : $person->birth_year }}
                            @else
                                ?
                            @endif
                            –
                            @if ($person->death_year)
                                {{ $person->death_year_uncertain ? 'ca. ' : '' }}{{ $person->death_year < 0 ? abs($person->death_year) . ' BCE' : $person->death_year }}
                            @else
                                ?
                            @endif
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6">

                    <!-- Description -->
                    @if ($person->description_en)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-2">Biography</h3>
                            <p class="text-[#435663]">{{ $person->description_en }}</p>
                        </div>
                    @endif

                    <!-- Alternative Names -->
                    @if ($person->alternativeNames && $person->alternativeNames->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Alternative Names</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($person->alternativeNames as $altName)
                                    <span class="inline-flex items-center bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">
                                        {{ $altName->name }}
                                        <span class="ml-1 text-xs text-gray-500">({{ $altName->language }})</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Games -->
                    @if ($person->games->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Games ({{ $person->games->count() }})</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                                @foreach ($person->games as $game)
                                    <a href="{{ route('games.show', $game->game_id) }}" class="group">
                                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                                            @if ($game->igdb && $game->igdb->cover_url)
                                                <div class="aspect-[3/4] bg-gray-200">
                                                    <img src="{{ $game->igdb->cover_url }}"
                                                         alt="{{ $game->title }}"
                                                         class="w-full h-full object-cover"
                                                         onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-gray-400 text-xs p-2 text-center\'>{{ $game->title }}</div>'">
                                                </div>
                                            @else
                                                <div class="aspect-[3/4] bg-gradient-to-br from-[#313647] to-[#435663] flex items-center justify-center p-2">
                                                    <span class="text-[#FFF8D4] text-xs text-center font-medium">{{ $game->title }}</span>
                                                </div>
                                            @endif
                                            <div class="p-2 bg-white">
                                                <h4 class="text-xs font-medium text-[#313647] truncate" title="{{ $game->title }}">{{ $game->title }}</h4>
                                                @if ($game->release_year)
                                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($game->release_year)->format('Y') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Linked Open Data -->
                    @if ($person->gnd_id || $person->wikidata_id)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Linked Open Data</h3>
                            <div class="space-y-2">
                                @if ($person->gnd_id)
                                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 121 139" class="w-5 h-5"><defs><style>.cls-1{fill:#006ab3;}.cls-2{fill:#fff;}</style></defs>
                                          <path id="Blau" class="cls-1" d="M120.29,34.72v69.45L60.14,138.9,0,104.17V34.72L60.14,0Z"/><path id="GND" class="cls-2" d="M45.33,50.41H54l7.65,14c.73,1.37,1.36,2.57,1.9,3.62l1.22,2.4c.29.56,1,2,2.13,4.29l0,.1-.4-24.43H75V88.49H66.32l-6.6-12c-.83-1.47-1.51-2.68-2-3.61s-1-1.78-1.35-2.54S55.58,68.79,55.2,68s-.94-1.93-1.68-3.48l.25,23.95H45.33Zm-6.74,7.71V50.41h-13a31.6,31.6,0,0,0-4,.35,14.65,14.65,0,0,0-4.32,1.43,12.92,12.92,0,0,0-4.33,3.64,17.44,17.44,0,0,0-3.1,6.61A29.19,29.19,0,0,0,9,69.77a26.89,26.89,0,0,0,1.15,8A15.39,15.39,0,0,0,13.69,84,12.19,12.19,0,0,0,17,86.5a15.7,15.7,0,0,0,3.71,1.32,23.92,23.92,0,0,0,3.49.51c1.08.07,2.35.12,3.82.16H38.59V67.88H30.25V80.45H26.92a15.52,15.52,0,0,1-4.65-.59A6.38,6.38,0,0,1,19,77.05a9.83,9.83,0,0,1-1.39-3.45,22.82,22.82,0,0,1-.35-4.2,16.58,16.58,0,0,1,1-6.21,7.53,7.53,0,0,1,2.49-3.4,7.72,7.72,0,0,1,3.16-1.37,24.69,24.69,0,0,1,3.89-.35h2.54ZM103.08,69.5a22.82,22.82,0,0,0-.35-4.2,9.88,9.88,0,0,0-1.39-3.46A6.42,6.42,0,0,0,98,59a15.38,15.38,0,0,0-4.64-.6H90V80.83h2.53a24.83,24.83,0,0,0,3.9-.35,7.88,7.88,0,0,0,3.16-1.38,7.5,7.5,0,0,0,2.49-3.39,16.58,16.58,0,0,0,1-6.21m8.25-.37a29.25,29.25,0,0,1-.84,7.33,17.44,17.44,0,0,1-3.1,6.61,12.92,12.92,0,0,1-4.33,3.64,15,15,0,0,1-4.32,1.43,31.6,31.6,0,0,1-4,.35h-13V50.41H92.25c1.47,0,2.74.09,3.82.16a23.92,23.92,0,0,1,3.49.51,15.7,15.7,0,0,1,3.71,1.32,12.51,12.51,0,0,1,3.33,2.48,15.49,15.49,0,0,1,3.58,6.26,26.84,26.84,0,0,1,1.15,8"/>
                                        </svg>
                                        <span class="text-sm font-medium text-[#313647]">GND</span>
                                        @if ($person->gnd_mapping)
                                            <span class="text-xs font-mono bg-green-200 text-green-800 px-2 py-1 rounded">{{ $person->gnd_mapping }}</span>
                                        @endif
                                        <a href="https://d-nb.info/gnd/{{ $person->gnd_id }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                            {{ $person->gnd_id }}
                                            <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                                @if ($person->wikidata_id)
                                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 930 545" class="w-5 h-5">
                                          <path d="m 120,545 h 30 V 45 H 120 V 545 z m 60,0 h 90 V 45 H 180 V 545 z M 300,45 V 545 h 90 V 45 h -90 z" fill="#990000"/>
                                          <path d="m 840,545 h 30 V 45 H 840 V 545 z M 900,45 V 545 h 30 V 45 H 900 z M 420,545 h 30 V 45 H 420 V 545 z M 480,45 V 545 h 30 V 45 h -30 z" fill="#339966"/>
                                          <path d="m 540,545 h 90 V 45 h -90 V 545 z m 120,0 h 30 V 45 H 660 V 545 z M 720,45 V 545 h 90 V 45 H 720 z" fill="#006699"/>
                                        </svg>
                                        <span class="text-sm font-medium text-[#313647]">Wikidata</span>
                                        @if ($person->wikidata_mapping)
                                            <span class="text-xs font-mono bg-green-200 text-green-800 px-2 py-1 rounded">{{ $person->wikidata_mapping }}</span>
                                        @endif
                                        <a href="https://www.wikidata.org/wiki/{{ $person->wikidata_id }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                            {{ $person->wikidata_id }}
                                            <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('persons.index') }}" class="inline-flex items-center text-[#435663] hover:text-[#313647]">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Historical Persons
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
