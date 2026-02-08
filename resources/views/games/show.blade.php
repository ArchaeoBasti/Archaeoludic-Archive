<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    {{ $game->title }}
                </h1>
                @auth
                    <a href="{{ route('games.edit', $game->game_id) }}" class="inline-flex items-center justify-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Gelber Streifen mit Schnell-Info -->
    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-6 text-[#313647]">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-medium">{{ \Carbon\Carbon::parse($game->release_year)->format('Y') }}</span>
                </div>
                @if ($game->igdb && $game->igdb->genres)
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span>{{ $game->igdb->genres }}</span>
                    </div>
                @endif
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                    <span>{{ count($game->citations) }} {{ count($game->citations) === 1 ? 'Reference' : 'References' }}</span>
                </div>
                @php
                    $lodCount = 0;
                    if (!empty($game->steam_id)) $lodCount++;
                    if (!empty($game->gog_id)) $lodCount++;
                    if (!empty($game->wikidata_id)) $lodCount++;
                    if ($game->igdb && $game->igdb->slug) $lodCount++;
                @endphp
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/>
                    </svg>
                    <span>{{ $lodCount }} LOD {{ $lodCount === 1 ? 'Link' : 'Links' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Cover Image -->
                        <div class="flex-shrink-0">
                            @if ($game->igdb && $game->igdb->cover_url)
                                <img src="{{ $game->igdb->cover_url }}" alt="{{ $game->title }}" class="w-64 rounded-lg shadow-lg">
                                <p class="text-xs text-gray-400 mt-2">
                                    Source:
                                    @if ($game->igdb->slug)
                                        <a href="{{ $game->igdb->slug }}" target="_blank" class="hover:underline">IGDB</a>
                                    @else
                                        IGDB
                                    @endif
                                </p>
                            @else
                                <div class="w-64 h-80 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500">No Cover</span>
                                </div>
                            @endif
                        </div>

                        <!-- Game Details -->
                        <div class="flex-grow">

                            @if ($game->igdb && $game->igdb->description)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-[#313647] mb-2">Description</h3>
                                    <p class="text-[#435663]">{{ $game->igdb->description }}</p>
                                    <p class="text-xs text-gray-400 mt-2">
                                        Source:
                                        @if ($game->igdb->slug)
                                            <a href="{{ $game->igdb->slug }}" target="_blank" class="hover:underline">IGDB</a>
                                        @else
                                            IGDB
                                        @endif
                                    </p>
                                </div>
                            @endif

                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-[#313647] mb-2">Release Date</h3>
                                <p class="text-[#435663]">{{ \Carbon\Carbon::parse($game->release_year)->format('F j, Y') }}</p>
                            </div>

                            @if ($game->igdb && $game->igdb->platforms)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-[#313647] mb-2">Platforms</h3>
                                    <p class="text-[#435663]">{{ $game->igdb->platforms }}</p>
                                    <p class="text-xs text-gray-400 mt-2">
                                        Source:
                                        @if ($game->igdb->slug)
                                            <a href="{{ $game->igdb->slug }}" target="_blank" class="hover:underline">IGDB</a>
                                        @else
                                            IGDB
                                        @endif
                                    </p>
                                </div>
                            @endif

                            <!-- Developers (from Database) -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-[#313647] mb-2">Developers</h3>
                                @forelse ($developers as $dev)
                                    <div class="flex items-center gap-2">
                                        @if ($dev->website)
                                            <a href="{{ $dev->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $dev->name }}</a>
                                        @else
                                            <span class="text-[#435663]">{{ $dev->name }}</span>
                                        @endif
                                        @if ($dev->wikidata_id)
                                            <a href="https://www.wikidata.org/wiki/{{ $dev->wikidata_id }}" target="_blank" title="Wikidata" class="hover:opacity-70 transition-opacity">
                                                <img src="https://www.wikidata.org/favicon.ico" width="16" class="inline">
                                            </a>
                                        @endif
                                    </div>
                                @empty
                                    <span class="text-gray-400">No developers listed</span>
                                @endforelse
                            </div>

                            <!-- Publisher (from IGDB) -->
                            @if ($game->igdb && $game->igdb->publishers)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-[#313647] mb-2">Publisher</h3>
                                    <p class="text-[#435663]">{{ $game->igdb->publishers }}</p>
                                    <p class="text-xs text-gray-400 mt-2">
                                        Source:
                                        @if ($game->igdb->slug)
                                            <a href="{{ $game->igdb->slug }}" target="_blank" class="hover:underline">IGDB</a>
                                        @else
                                            IGDB
                                        @endif
                                    </p>
                                </div>
                            @endif

                            <!-- Vocabulary Section -->
                            @if ($periods->count() > 0 || $places->count() > 0 || $gameplayModes->count() > 0 || $playerRoles->count() > 0 || $tropes->count() > 0 || $persons->count() > 0)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-[#313647] mb-3">Classification</h3>

                                    <!-- Periods -->
                                    @if ($periods->count() > 0)
                                        <div class="mb-3">
                                            <span class="text-sm font-medium text-[#435663]">Periods:</span>
                                            <div class="inline-flex flex-wrap gap-2 ml-2">
                                                @foreach ($periods as $period)
                                                    <a href="{{ route('periods.show', $period->id) }}"
                                                       class="inline-flex items-center bg-sky-100 text-sky-800 px-3 py-1 rounded-full text-sm hover:bg-sky-200 transition-colors">
                                                        {{ $period->label_en }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Places -->
                                    @if ($places->count() > 0)
                                        <div class="mb-3">
                                            <span class="text-sm font-medium text-[#435663]">Places:</span>

                                            @php
                                                // Sammle alle Places mit Koordinaten aus dem Spiel
                                                $placesWithCoords = $places->filter(function($place) {
                                                    return $place->latitude && $place->longitude;
                                                });
                                            @endphp

                                            @if ($placesWithCoords->count() > 0)
                                                <div class="mb-2">
                                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                                        <div id="game-places-map" class="h-64 w-full"></div>
                                                    </div>
                                                    <p class="text-xs text-gray-400 mt-2">
                                                        {{ $placesWithCoords->count() }} {{ $placesWithCoords->count() === 1 ? 'location' : 'locations' }} mapped
                                                    </p>
                                                </div>
                                            @endif

                                            <div class="inline-flex flex-wrap gap-2">
                                                @foreach ($places as $place)
                                                    <a href="{{ route('places.show', $place->id) }}"
                                                       class="inline-flex items-center bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm hover:bg-emerald-200 transition-colors">
                                                        {{ $place->label_en }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Historical Persons Section -->
                                    @if ($persons->count() > 0)
                                        <div class="mb-3">
                                            <span class="text-sm font-medium text-[#435663]">Historical Persons:</span>
                                            <div class="inline-flex flex-wrap gap-2 ml-2">
                                                @foreach ($persons as $person)
                                                    <a href="{{ route('persons.show', $person->id) }}"
                                                       class="inline-flex items-center bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-sm hover:bg-amber-200 transition-colors">
                                                        <span class="font-medium text-[#313647]">{{ $person->label_en }}</span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Tropes Section -->
                                    @if ($tropes->count() > 0)
                                        <div class="mb-3">
                                            <span class="text-sm font-medium text-[#435663]">Tropes:</span>
                                            <div class="inline-flex flex-wrap gap-2 ml-2">
                                                @foreach ($tropes as $trope)
                                                    <a href="{{ route('tropes.show', $trope->id) }}"
                                                       class="inline-flex items-center bg-rose-100 text-rose-800 px-3 py-1 rounded-full text-sm hover:bg-rose-200 transition-colors">
                                                        {{ $trope->label_en }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Gameplay Modes -->
                                    @if ($gameplayModes->count() > 0)
                                        <div class="mb-3">
                                            <span class="text-sm font-medium text-[#435663]">Gameplay Modes:</span>
                                            <div class="inline-flex flex-wrap gap-2 ml-2">
                                                @foreach ($gameplayModes as $mode)
                                                    <a href="{{ route('gameplay-modes.show', $mode->id) }}"
                                                       class="inline-flex items-center bg-violet-100 text-violet-800 px-3 py-1 rounded-full text-sm hover:bg-violet-200 transition-colors">
                                                        {{ $mode->label_en }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Player Roles -->
                                    @if ($playerRoles->count() > 0)
                                        <div class="mb-3">
                                            <span class="text-sm font-medium text-[#435663]">Player Roles:</span>
                                            <div class="inline-flex flex-wrap gap-2 ml-2">
                                                @foreach ($playerRoles as $role)
                                                    <a href="{{ route('player-roles.show', $role->id) }}"
                                                       class="inline-flex items-center bg-slate-200 text-slate-800 px-3 py-1 rounded-full text-sm hover:bg-slate-300 transition-colors">
                                                        {{ $role->label_en }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Linked Open Data -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-[#313647] mb-2">Linked Open Data</h3>
                                <div class="flex gap-4">
                                    @if ($game->steam_id)
                                        <a href="https://store.steampowered.com/app/{{ $game->steam_id }}/" target="_blank" title="Steam" class="hover:opacity-70 transition-opacity">
                                            <img src="https://store.steampowered.com/favicon.ico" width="24">
                                        </a>
                                    @endif
                                    @if ($game->gog_id)
                                        <a href="https://www.gog.com/{{ $game->gog_id }}/" target="_blank" title="GOG" class="hover:opacity-70 transition-opacity">
                                            <img src="https://www.gog.com/favicon.ico" width="24">
                                        </a>
                                    @endif
                                    @if ($game->wikidata_id)
                                        <a href="https://www.wikidata.org/wiki/{{ $game->wikidata_id }}" target="_blank" title="Wikidata" class="hover:opacity-70 transition-opacity">
                                            <img src="https://www.wikidata.org/favicon.ico" width="24">
                                        </a>
                                    @endif
                                    @if ($game->igdb && $game->igdb->slug)
                                        <a href="{{ $game->igdb->slug }}" target="_blank" title="IGDB" class="hover:opacity-70 transition-opacity">
                                            <img src="https://www.igdb.com/favicon.ico" width="24">
                                        </a>
                                    @endif
                                </div>
                                @if (!$game->steam_id && !$game->gog_id && !$game->wikidata_id && !($game->igdb && $game->igdb->slug))
                                    <span class="text-gray-400">No linked data available</span>
                                @endif
                            </div>

                            <!-- Literature -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-[#313647] mb-2">Literature</h3>
                                @if (count($game->citations) > 0)
                                    <ul class="space-y-2">
                                        @foreach ($game->citations as $cite)
                                            <li class="text-[#435663]">
                                                {!! app(App\Services\ZoteroService::class)->getHarvardCitation($cite['key']) !!}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-400">No literature listed</span>
                                @endif
                            </div>

                            <!-- Citation Section -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-[#313647] mb-2">Cite This Game</h3>
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    @php
                                        // Build citation components
                                        // Use developers from database
                                        $developerNames = $developers->pluck('name')->implode(', ');
                                        $year = \Carbon\Carbon::parse($game->release_year)->format('Y');
                                        $title = $game->title;
                                        $platforms = $game->igdb->platforms ?? null;
                                        $publisher = $game->igdb->publishers ?? null;

                                        // Build the citation string
                                        $citationParts = [];

                                        // Developer. (Year).
                                        if ($developerNames) {
                                            $citationParts[] = $developerNames . '. (' . $year . ').';
                                        } else {
                                            $citationParts[] = '(' . $year . ').';
                                        }

                                        // Title [Platforms].
                                        if ($platforms) {
                                            $citationParts[] = '<em>' . e($title) . '</em> [' . $platforms . '].';
                                        } else {
                                            $citationParts[] = '<em>' . e($title) . '</em>.';
                                        }

                                        // Digital game published by publisher.
                                        if ($publisher) {
                                            $citationParts[] = 'Digital game published by ' . $publisher . '.';
                                        } else {
                                            $citationParts[] = 'Digital game.';
                                        }

                                        $citation = implode(' ', $citationParts);

                                        // Plain text version for copying
                                        $citationPlain = strip_tags(str_replace(['<em>', '</em>'], '', $citation));
                                    @endphp

                                    <p class="text-[#435663] mb-3" id="citation-text">{!! $citation !!}</p>

                                    <p class="text-xs text-gray-400 mt-3">
                                        Citation format roughly based on the
                                        <a href="https://gamestudies.org/0902/submission_guidelines" target="_blank" class="underline hover:text-gray-600">gamestudies.org Submission Guidelines</a>.
                                        @if (!$developerNames || !$publisher)
                                            <br><span class="text-amber-600">Note: Some citation fields are missing. Consider adding developer/publisher data.</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('games') }}" class="inline-flex items-center text-[#435663] hover:text-[#313647] transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Games
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet Map Scripts (nur wenn Places mit Koordinaten existieren) -->
    @if (isset($placesWithCoords) && $placesWithCoords->count() > 0)
        @push('styles')
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <style>
                .custom-marker {
                    background: transparent;
                    border: none;
                }
                .place-popup-link {
                    color: #313647;
                    font-weight: 600;
                    text-decoration: none;
                }
                .place-popup-link:hover {
                    color: #435663;
                    text-decoration: underline;
                }
            </style>
        @endpush

        @push('scripts')
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <script>
                let map;
                let markers = [];

                // Places data for this game
                const places = [
                    @foreach ($placesWithCoords as $place)
                    {
                        id: {{ $place->id }},
                        label: "{{ addslashes($place->label_en) }}",
                        lat: {{ $place->latitude }},
                        lng: {{ $place->longitude }},
                        url: "{{ route('places.show', $place->id) }}",
                        identifier: "{{ $place->identifier }}"
                    },
                    @endforeach
                ];

                document.addEventListener('DOMContentLoaded', function() {
                    // Initialize map
                    map = L.map('game-places-map').setView([30, 0], 2);

                    // Add CartoDB Voyager tiles
                    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
                    }).addTo(map);

                    // Custom circle marker icon
                    const customIcon = L.divIcon({
                        className: 'custom-marker',
                        html: `<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="8" cy="8" r="6" fill="#313647" stroke="#313647" stroke-width="1"/>
                            <circle cx="8" cy="8" r="4" fill="#FFF8D4"/>
                        </svg>`,
                        iconSize: [16, 16],
                        iconAnchor: [8, 8],
                        popupAnchor: [0, -10]
                    });

                    // Add markers for each place
                    places.forEach(place => {
                        const marker = L.marker([place.lat, place.lng], { icon: customIcon })
                            .bindPopup(`
                                <div>
                                    <span style="font-size: 11px; color: #9ca3af;">${place.identifier}</span><br>
                                    <a href="${place.url}" class="place-popup-link">${place.label}</a><br>
                                    <span style="font-size: 13px; color: #6b7280;">${place.lat}, ${place.lng}</span>
                                </div>
                            `);
                        marker.addTo(map);
                        markers.push(marker);
                    });

                    // Fit bounds if we have markers
                    if (markers.length > 0) {
                        const group = L.featureGroup(markers);
                        map.fitBounds(group.getBounds().pad(0.1));
                    }
                });
            </script>
        @endpush
    @endif
</x-app-layout>
