<x-app-layout>
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">{{ $place->label_en }}</h1>
                @auth
                    <a href="{{ route('places.edit', $place) }}" class="inline-flex items-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4]">
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
                    <span class="font-medium">{{ $place->identifier }}</span>
                </div>
                @if ($place->latitude && $place->longitude)
                    <a href="https://www.openstreetmap.org/?mlat={{ $place->latitude }}&mlon={{ $place->longitude }}&zoom=10" target="_blank" class="flex items-center gap-2 text-[#435663] hover:text-[#313647] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $place->latitude }}, {{ $place->longitude }}</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6">

                    <!-- Description -->
                    @if ($place->description_en)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-2">Description</h3>
                            <p class="text-[#435663]">{{ $place->description_en }}</p>
                        </div>
                    @endif

                    <!-- Alternative Names -->
                    @if ($place->alternativeNames && $place->alternativeNames->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Alternative Names</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($place->alternativeNames as $altName)
                                    <span class="inline-flex items-stretch bg-gray-100 text-gray-800 rounded-sm text-sm overflow-hidden">
                                        <span class="flex items-center bg-gray-500 text-gray-100 px-2 text-xs">
                                            {{ strtoupper($altName->language) }}
                                        </span>
                                        <span class="px-3 py-1">
                                            {{ $altName->name }}
                                        </span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Parent Place -->
                    @if ($place->parent)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-2">Parent Place</h3>
                            <a href="{{ route('places.show', $place->parent) }}" class="inline-flex items-center bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm hover:bg-emerald-200 transition-colors">
                                {{ $place->parent->label_en }}
                            </a>
                        </div>
                    @endif

                    <!-- Child Places -->
                    @if ($place->children->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Sub-Places</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($place->children->sortBy('label_en') as $child)
                                    <a href="{{ route('places.show', $child) }}" class="inline-flex items-center bg-emerald-100 text-emerald-800 px-3 py-2 rounded-full text-sm hover:bg-emerald-200 transition-colors">
                                        {{ $child->label_en }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Games -->
                    @if ($place->games->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Games ({{ $place->games->count() }})</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                                @foreach ($place->games as $game)
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
                    @if ($place->tgn_id)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Linked Open Data</h3>
                            <div class="space-y-2">
                                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                                    <img src="{{ asset('images/the-getty-logo.png') }}" alt="The Getty" class="w-5 h-5">
                                    <span class="text-sm font-medium text-[#313647]">Getty TGN</span>
                                    @if ($place->tgn_mapping)
                                        <span class="text-xs font-mono bg-green-200 text-green-800 px-2 py-1 rounded">{{ $place->tgn_mapping }}</span>
                                    @endif
                                    <a href="http://vocab.getty.edu/tgn/{{ $place->tgn_id }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                        {{ $place->tgn_id }}
                                        <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('places.index') }}" class="inline-flex items-center text-[#435663] hover:text-[#313647]">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Places
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
