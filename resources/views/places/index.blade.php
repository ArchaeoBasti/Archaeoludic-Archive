<x-app-layout>
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">Places</h1>
                @auth
                    <a href="{{ route('places.create') }}" class="inline-flex items-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Place
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="font-medium">{{ $places->count() }} Places</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                    <span class="font-medium">{{ $topLevelPlaces->count() }} Top-Level</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section - Hidden on mobile -->
    <div class="hidden md:block bg-gray-100 border-b border-gray-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden border-x border-gray-200">
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="font-semibold text-[#313647]">Map Overview</h2>
                    <button
                        onclick="resetMapView()"
                        class="text-sm text-[#435663] hover:text-[#313647] underline"
                    >
                        Reset View
                    </button>
                </div>
                <div id="places-map" class="h-96 w-full"></div>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <!-- Expand/Collapse All Controls -->
                    <div class="flex gap-4 mb-6" x-data>
                        <button
                            @click="$dispatch('expand-all')"
                            class="text-sm text-[#435663] hover:text-[#313647] underline"
                        >
                            Expand All
                        </button>
                        <button
                            @click="$dispatch('collapse-all')"
                            class="text-sm text-[#435663] hover:text-[#313647] underline"
                        >
                            Collapse All
                        </button>
                    </div>

                    @foreach ($topLevelPlaces as $place)
                        <div
                            class="mb-4"
                            x-data="{ open: false }"
                            @expand-all.window="open = true"
                            @collapse-all.window="open = false"
                        >
                            <!-- Accordion Header -->
                            <button
                                @click="open = !open"
                                class="w-full flex justify-between items-center text-lg font-semibold text-[#313647] border-b border-[#A3B087] pb-2 hover:text-[#435663] transition-colors text-left"
                            >
                                <span class="flex items-center gap-3">
                                    {{ $place->label_en }}
                                    <span class="text-sm font-normal text-gray-500">
                                        @php
                                            $totalCount = 1 + $place->children->count() + $place->children->sum(fn($child) => $child->children->count());
                                        @endphp
                                        ({{ $totalCount }} {{ $totalCount === 1 ? 'entry' : 'entries' }})
                                    </span>
                                </span>
                                <svg
                                    class="w-5 h-5 transform transition-transform duration-200"
                                    :class="{ 'rotate-180': open }"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Accordion Content -->
                            <div
                                x-show="open"
                                x-collapse
                                x-cloak
                                class="mt-4"
                            >
                                <!-- Top-Level Place -->
                                <div class="flex justify-between items-start p-4 bg-gray-50 rounded-lg border border-gray-200 mb-2">
                                    <div>
                                        <span class="text-xs text-gray-400">{{ $place->identifier }}</span>
                                        <h4 class="font-medium text-[#313647]">
                                            <a href="{{ route('places.show', $place) }}" class="hover:text-[#435663] transition-colors">
                                                {{ $place->label_en }}
                                            </a>
                                        </h4>
                                        @if ($place->latitude && $place->longitude)
                                            <p class="text-sm text-[#435663]">
                                                <a href="https://www.openstreetmap.org/?mlat={{ $place->latitude }}&mlon={{ $place->longitude }}&zoom=12" target="_blank" class="hover:underline">
                                                    📍 {{ $place->latitude }}, {{ $place->longitude }}
                                                </a>
                                            </p>
                                        @endif
                                        @if ($place->tgn_id)
                                            <a href="https://vocab.getty.edu/page/tgn/{{ $place->tgn_id }}" target="_blank" class="text-sm text-blue-600 hover:underline">TGN: {{ $place->tgn_id }}</a>
                                        @endif
                                        @if ($place->description_en)
                                            <p class="text-[#435663] text-sm mt-1">{{ Str::limit($place->description_en, 200) }}</p>
                                        @endif
                                    </div>
                                    @auth
                                        <a href="{{ route('places.edit', $place) }}" class="text-blue-600 hover:underline">Edit</a>
                                    @endauth
                                </div>

                                <!-- Second Level (Children) -->
                                @if ($place->children->count() > 0)
                                    <div class="ml-6 space-y-2">
                                        @foreach ($place->children->sortBy('label_en') as $child)
                                            <div class="flex justify-between items-start p-4 bg-white rounded-lg border border-gray-200">
                                                <div>
                                                    <span class="text-xs text-gray-400">{{ $child->identifier }}</span>
                                                    <h4 class="font-medium text-[#313647]">
                                                        <a href="{{ route('places.show', $child) }}" class="hover:text-[#435663] transition-colors">
                                                            {{ $child->label_en }}
                                                        </a>
                                                    </h4>
                                                    @if ($child->latitude && $child->longitude)
                                                        <p class="text-sm text-[#435663]">
                                                            <a href="https://www.openstreetmap.org/?mlat={{ $child->latitude }}&mlon={{ $child->longitude }}&zoom=12" target="_blank" class="hover:underline">
                                                                📍 {{ $child->latitude }}, {{ $child->longitude }}
                                                            </a>
                                                        </p>
                                                    @endif
                                                    @if ($child->tgn_id)
                                                        <a href="https://vocab.getty.edu/page/tgn/{{ $child->tgn_id }}" target="_blank" class="text-sm text-blue-600 hover:underline">TGN: {{ $child->tgn_id }}</a>
                                                    @endif
                                                    @if ($child->description_en)
                                                        <p class="text-[#435663] text-sm mt-1">{{ Str::limit($child->description_en, 200) }}</p>
                                                    @endif
                                                </div>
                                                @auth
                                                    <a href="{{ route('places.edit', $child) }}" class="text-blue-600 hover:underline">Edit</a>
                                                @endauth
                                            </div>

                                            <!-- Third Level (Grandchildren) -->
                                            @if ($child->children->count() > 0)
                                                <div class="ml-6 space-y-2">
                                                    @foreach ($child->children->sortBy('label_en') as $grandchild)
                                                        <div class="flex justify-between items-start p-4 bg-gray-100 rounded-lg border border-gray-200">
                                                            <div>
                                                                <span class="text-xs text-gray-400">{{ $grandchild->identifier }}</span>
                                                                <h4 class="font-medium text-[#313647]">
                                                                    <a href="{{ route('places.show', $grandchild) }}" class="hover:text-[#435663] transition-colors">
                                                                        {{ $grandchild->label_en }}
                                                                    </a>
                                                                </h4>
                                                                @if ($grandchild->latitude && $grandchild->longitude)
                                                                    <p class="text-sm text-[#435663]">
                                                                        <a href="https://www.openstreetmap.org/?mlat={{ $grandchild->latitude }}&mlon={{ $grandchild->longitude }}&zoom=12" target="_blank" class="hover:underline">
                                                                            📍 {{ $grandchild->latitude }}, {{ $grandchild->longitude }}
                                                                        </a>
                                                                    </p>
                                                                @endif
                                                                @if ($grandchild->tgn_id)
                                                                    <a href="https://vocab.getty.edu/page/tgn/{{ $grandchild->tgn_id }}" target="_blank" class="text-sm text-blue-600 hover:underline">TGN: {{ $grandchild->tgn_id }}</a>
                                                                @endif
                                                                @if ($grandchild->description_en)
                                                                    <p class="text-[#435663] text-sm mt-1">{{ Str::limit($grandchild->description_en, 200) }}</p>
                                                                @endif
                                                            </div>
                                                            @auth
                                                                <a href="{{ route('places.edit', $grandchild) }}" class="text-blue-600 hover:underline">Edit</a>
                                                            @endauth
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    @if ($places->isEmpty())
                        <p class="text-gray-400">No places defined yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <style>
            .leaflet-popup-content-wrapper {
                border-radius: 8px;
            }
            .leaflet-popup-content {
                margin: 12px 16px;
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
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            let map;
            let markers = [];
            const defaultCenter = [30, 20];
            const defaultZoom = 2;

            // Place data generated from Blade (only second and third level)
            const places = [
                @foreach($topLevelPlaces as $topLevel)
                    @foreach($topLevel->children as $child)
                        @if($child->latitude && $child->longitude)
                        {
                            id: {{ $child->id }},
                            label: "{{ addslashes($child->label_en) }}",
                            lat: {{ $child->latitude }},
                            lng: {{ $child->longitude }},
                            url: "{{ route('places.show', $child) }}",
                            identifier: "{{ $child->identifier }}"
                        },
                        @endif
                        @foreach($child->children as $grandchild)
                            @if($grandchild->latitude && $grandchild->longitude)
                            {
                                id: {{ $grandchild->id }},
                                label: "{{ addslashes($grandchild->label_en) }}",
                                lat: {{ $grandchild->latitude }},
                                lng: {{ $grandchild->longitude }},
                                url: "{{ route('places.show', $grandchild) }}",
                                identifier: "{{ $grandchild->identifier }}"
                            },
                            @endif
                        @endforeach
                    @endforeach
                @endforeach
            ];

            document.addEventListener('DOMContentLoaded', function() {
                // Initialize map
                map = L.map('places-map').setView(defaultCenter, defaultZoom);

                // Add CartoDB Voyager tiles
                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
                }).addTo(map);

                // Custom marker icon in your color scheme
                const customIcon = L.divIcon({
                    className: 'custom-marker',
                    html: `<svg width="24" height="36" viewBox="0 0 24 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 0C5.37 0 0 5.37 0 12c0 9 12 24 12 24s12-15 12-24c0-6.63-5.37-12-12-12z" fill="#313647"/>
                        <circle cx="12" cy="12" r="5" fill="#FFF8D4"/>
                    </svg>`,
                    iconSize: [24, 36],
                    iconAnchor: [12, 36],
                    popupAnchor: [0, -36]
                });

                // Add markers for each place
                places.forEach(place => {
                    const marker = L.marker([place.lat, place.lng], { icon: customIcon })
                        .addTo(map)
                        .bindPopup(`
                            <div>
                                <span style="font-size: 11px; color: #9ca3af;">${place.identifier}</span><br>
                                <a href="${place.url}" class="place-popup-link">${place.label}</a><br>
                                <span style="font-size: 13px; color: #6b7280;">${place.lat}, ${place.lng}</span>
                            </div>
                        `);
                    markers.push(marker);
                });

                // Fit bounds if we have markers
                if (markers.length > 0) {
                    const group = L.featureGroup(markers);
                    map.fitBounds(group.getBounds().pad(0.1));
                }
            });

            function panToLocation(lat, lng) {
                map.setView([lat, lng], 8, { animate: true });

                // Find and open the marker popup
                markers.forEach(marker => {
                    const pos = marker.getLatLng();
                    if (Math.abs(pos.lat - lat) < 0.0001 && Math.abs(pos.lng - lng) < 0.0001) {
                        marker.openPopup();
                    }
                });
            }

            function resetMapView() {
                if (markers.length > 0) {
                    const group = L.featureGroup(markers);
                    map.fitBounds(group.getBounds().pad(0.1));
                } else {
                    map.setView(defaultCenter, defaultZoom);
                }
            }
        </script>
    @endpush
</x-app-layout>
