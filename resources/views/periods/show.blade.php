<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    {{ $period->label_en }}
                </h1>
                @auth
                    <a href="{{ route('periods.edit', $period) }}" class="inline-flex items-center justify-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Gelber Streifen mit Zeitspanne -->
    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-6 text-[#313647]">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">
                        @if ($period->start_year || $period->end_year)
                            @if ($period->start_year)
                                {{ $period->start_year < 0 ? abs($period->start_year) . ' BCE' : $period->start_year . ' CE' }}{{ $period->start_uncertain ? '?' : '' }}
                            @else
                                ?
                            @endif
                            –
                            @if ($period->end_year)
                                {{ $period->end_year < 0 ? abs($period->end_year) . ' BCE' : $period->end_year . ' CE' }}{{ $period->end_uncertain ? '?' : '' }}
                            @else
                                ?
                            @endif
                        @else
                            No dates specified
                        @endif
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span class="font-medium">{{ $period->identifier }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">

                    <!-- Description -->
                    @if ($period->description_en)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-2">Description</h3>
                            <p class="text-[#435663]">{{ $period->description_en }}</p>
                        </div>
                    @endif

                    <!-- Parent Period -->
                    @if ($period->parent)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-2">Parent Period</h3>
                            <a href="{{ route('periods.show', $period->parent) }}" class="inline-flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm hover:bg-blue-200 transition-colors">
                                {{ $period->parent->label_en }}
                            </a>
                        </div>
                    @endif

                    <!-- Child Periods -->
                    @if ($period->children->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Sub-Periods</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($period->children->sortBy('start_year') as $child)
                                    <a href="{{ route('periods.show', $child) }}" class="inline-flex items-center bg-blue-100 text-blue-800 px-3 py-2 rounded-full text-sm hover:bg-blue-200 transition-colors">
                                        <span>{{ $child->label_en }}</span>
                                        @if ($child->start_year || $child->end_year)
                                            <span class="ml-2 text-blue-600 text-xs">
                                                ({{ $child->start_year < 0 ? abs($child->start_year) . ' BCE' : $child->start_year }} – {{ $child->end_year < 0 ? abs($child->end_year) . ' BCE' : $child->end_year }})
                                            </span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Games -->
                    @if ($period->games->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Games ({{ $period->games->count() }})</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                                @foreach ($period->games as $game)
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

                    <!-- Mappings -->
                    @if ($period->mappings->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Linked Data</h3>
                            <div class="space-y-2">
                                @foreach ($period->mappings as $mapping)
                                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                                        <span class="text-xs font-mono bg-gray-200 px-2 py-1 rounded">{{ $mapping->match_type }}</span>
                                        <span class="text-sm text-[#435663]">{{ $mapping->external_source }}</span>
                                        <a href="{{ $mapping->external_uri }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                            {{ $mapping->external_uri }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('periods.index') }}" class="inline-flex items-center text-[#435663] hover:text-[#313647]">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Periods
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
