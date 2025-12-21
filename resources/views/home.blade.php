<x-app-layout>
    <div class="relative overflow-hidden bg-gradient-to-br from-[#313647] to-[#435663]">
        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="text-center">
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <svg viewBox="0 0 57 57" xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 sm:w-32 sm:h-32">
                        <path style="fill:none;stroke:#FFF8D4;stroke-width:2;stroke-linecap:round;stroke-miterlimit:10;" d="M29,27.528v-12.5c0-2.475,2.025-4.5,4.5-4.5h0c2.475,0,4.5,2.025,4.5,4.5v3.5c0,2.2,1.8,4,4,4h0c2.2,0,4-1.8,4-4v-16"/>
                        <path style="fill:#A3B087;" d="M45.241,55.471c-1.303,0.022-5.452-0.268-9.314-1.331c-4.514-1.242-10.121-1.237-14.637,0c-3.892,1.066-7.521,1.354-9.314,1.331C5.142,55.383,0,48.52,0,41.499v0c0-7.684,6.287-13.972,13.972-13.972h29.274C50.93,27.528,57,33.815,57,41.499v0C57,48.52,52.075,55.355,45.241,55.471z"/>
                        <line style="fill:none;stroke:#FFF8D4;stroke-width:2;stroke-linecap:round;stroke-miterlimit:10;" x1="27" y1="31.528" x2="31.632" y2="31.528"/>
                        <circle style="fill:#43B05C;" cx="36" cy="41.528" r="3"/>
                        <circle style="fill:#DD352E;" cx="50" cy="41.528" r="3"/>
                        <circle style="fill:#EBBA16;" cx="43" cy="48.528" r="3"/>
                        <circle style="fill:#366DB6;" cx="43" cy="34.528" r="3"/>
                        <polygon style="fill:#313647;" points="22,38.528 18,38.528 18,34.528 12,34.528 12,38.528 8,38.528 8,44.528 12,44.528 12,48.528 18,48.528 18,44.528 22,44.528"/>
                    </svg>
                </div>

                <!-- Title -->
                <h1 class="text-4xl sm:text-5xl font-bold text-[#FFF8D4] mb-4">
                    The Archaeoludic Archive
                </h1>

                <!-- Tagline -->
                <p class="text-lg sm:text-xl text-[#A3B087] max-w-2xl mx-auto mb-8">
                    A curated database of video games engaging with archaeology, cultural heritage, and the ancient past
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('games') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-[#A3B087] text-[#A3B087] font-semibold rounded-lg hover:bg-[#A3B087] hover:text-[#313647] transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Browse Games
                    </a>
                    <a href="{{ route('vocabulary') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-[#A3B087] text-[#A3B087] font-semibold rounded-lg hover:bg-[#A3B087] hover:text-[#313647] transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Browse Vocabulary
                    </a>
                    <a href="{{ route('bibliography') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-[#A3B087] text-[#A3B087] font-semibold rounded-lg hover:bg-[#A3B087] hover:text-[#313647] transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                        Browse Bibliography
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="bg-[#FFF8D4] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8">
                <!-- Games -->
                <div class="text-center">
                    <div class="text-4xl sm:text-5xl font-bold text-[#313647]">{{ $stats['games'] }}</div>
                    <div class="text-[#435663] mt-1">Games</div>
                </div>

                <!-- Developers -->
                <div class="text-center">
                    <div class="text-4xl sm:text-5xl font-bold text-[#313647]">{{ $stats['developers'] }}</div>
                    <div class="text-[#435663] mt-1">Developers</div>
                </div>

                <!-- Citations -->
                <div class="text-center">
                    <div class="text-4xl sm:text-5xl font-bold text-[#313647]">{{ $stats['citations'] }}</div>
                    <div class="text-[#435663] mt-1">Scholarly References</div>
                </div>

                <!-- Vocabularies -->
                <div class="text-center">
                    <div class="text-4xl sm:text-5xl font-bold text-[#313647]">{{ $stats['vocabularies'] }}</div>
                    <div class="text-[#435663] mt-1">Vocabulary Terms</div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="py-12 sm:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-2xl sm:text-3xl font-bold text-[#313647] mb-6">About the Archive</h2>
                <p class="text-[#435663] leading-relaxed mb-4">
                    The Archaeoludic Archive is a curated database documenting video games that engage with archaeology, cultural heritage, and the ancient past. From iconic adventurers like Lara Croft to strategy games set in ancient civilizations, these games shape how millions of players perceive and interact with history.
                </p>
                <p class="text-[#435663] leading-relaxed mb-4">
                    Each entry is enriched with linked open data connections to Wikidata, IGDB, Steam, and GOG, ensuring interoperability with other digital humanities projects. Scholarly references are managed through Zotero, linking games directly to academic literature that analyzes their historical representations, gameplay mechanics, and cultural impact.
                </p>
                <p class="text-[#435663] leading-relaxed mb-8">
                    This resource serves researchers studying digital heritage, educators seeking to incorporate games into teaching, and anyone interested in how interactive media represent and interpret the past. By applying a controlled vocabulary for archaeological and historical content, the archive enables systematic analysis of player roles, time periods, and cultural contexts across the gaming landscape.
                </p>

                <!-- Linked Data Icons -->
                <div class="flex flex-wrap justify-center gap-6 text-[#435663]">
                    <a href="https://www.wikidata.org" target="_blank" class="flex items-center gap-2 hover:text-[#313647] transition-colors">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                        </svg>
                        <span class="text-sm">Wikidata</span>
                    </a>
                    <a href="https://www.igdb.com" target="_blank" class="flex items-center gap-2 hover:text-[#313647] transition-colors">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 6H3c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-10 7H8v3H6v-3H3v-2h3V8h2v3h3v2zm4.5 2c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm4-3c-.83 0-1.5-.67-1.5-1.5S18.67 9 19.5 9s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                        </svg>
                        <span class="text-sm">IGDB</span>
                    </a>
                    <a href="https://store.steampowered.com" target="_blank" class="flex items-center gap-2 hover:text-[#313647] transition-colors">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM9.5 16.5v-9l7 4.5-7 4.5z"/>
                        </svg>
                        <span class="text-sm">Steam</span>
                    </a>
                    <a href="https://www.gog.com" target="_blank" class="flex items-center gap-2 hover:text-[#313647] transition-colors">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm">GOG</span>
                    </a>
                    <a href="https://www.zotero.org" target="_blank" class="flex items-center gap-2 hover:text-[#313647] transition-colors">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                        <span class="text-sm">Zotero</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Games Section -->
    @if($latestGames->count() > 0)
    <div class="py-12 sm:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-[#313647]">Recently Added</h2>
                <a href="{{ route('games') }}" class="text-[#435663] hover:text-[#313647] font-medium flex items-center gap-1">
                    View all
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Kacheln wie in index.blade.php -->
            <div class="flex flex-wrap gap-6 justify-start">
                @foreach($latestGames as $game)
                    <a href="{{ route('games.show', $game->game_id) }}" class="border rounded-lg p-2 hover:shadow-lg transition-shadow w-[200px] block bg-white">
                        @if ($game->igdb && $game->igdb->cover_url)
                            <img src="{{ $game->igdb->cover_url }}" alt="{{ $game->title }}" class="w-full rounded">
                        @else
                            <div class="w-full h-40 bg-gray-200 rounded flex items-center justify-center">
                                <span class="text-gray-500 text-sm text-center px-2">{{ $game->title }}</span>
                            </div>
                        @endif
                        <h3 class="mt-2 text-sm font-semibold truncate" title="{{ $game->title }}">{{ $game->title }}</h3>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>{{ substr($game->release_year, 0, 4) }}</span>
                            <div class="flex space-x-2">
                                <span title="Literaturnachweise" class="flex items-center text-amber-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-0.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                    </svg>
                                    {{ $game->literature_count }}
                                </span>
                                &nbsp;
                                <span title="Linked Open Data" class="flex items-center text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-0.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                    </svg>
                                    {{ $game->lod_count }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
