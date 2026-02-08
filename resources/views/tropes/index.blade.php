<x-app-layout>
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">Tropes</h1>
                @auth
                    <a href="{{ route('tropes.create') }}" class="inline-flex items-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Trope
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-[#313647]">
                <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span class="font-medium"><span id="visible-count">{{ $tropes->count() }}</span> Tropes</span>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">

                    <!-- Alphabetischer Filter -->
                    @php
                        // Sammle alle Anfangsbuchstaben der Tropes
                        $availableLetters = $tropes->map(function($trope) {
                            $firstChar = strtoupper(substr($trope->label_en, 0, 1));
                            return ctype_alpha($firstChar) ? $firstChar : '#';
                        })->unique()->toArray();
                    @endphp

                    <div class="mb-6 flex flex-wrap gap-1 justify-center" x-data="{ activeFilter: 'all' }">
                        <button
                            @click="activeFilter = 'all'; filterTropes('all')"
                            :class="activeFilter === 'all' ? 'bg-[#313647] text-[#FFF8D4]' : 'bg-gray-100 text-[#313647] hover:bg-gray-200'"
                            class="px-3 py-1 rounded text-sm font-medium transition-colors"
                        >
                            All
                        </button>
                        <button
                            @click="@if(in_array('#', $availableLetters))activeFilter = '#'; filterTropes('#')@endif"
                            :class="activeFilter === '#' ? 'bg-[#313647] text-[#FFF8D4]' : ''"
                            class="px-3 py-1 rounded text-sm font-medium transition-colors {{ in_array('#', $availableLetters) ? 'bg-gray-100 text-[#313647] hover:bg-gray-200' : 'bg-gray-50 text-gray-300 cursor-default' }}"
                        >
                            #
                        </button>
                        @foreach (range('A', 'Z') as $letter)
                            <button
                                @click="@if(in_array($letter, $availableLetters))activeFilter = '{{ $letter }}'; filterTropes('{{ $letter }}')@endif"
                                :class="activeFilter === '{{ $letter }}' ? 'bg-[#313647] text-[#FFF8D4]' : ''"
                                class="px-3 py-1 rounded text-sm font-medium transition-colors {{ in_array($letter, $availableLetters) ? 'bg-gray-100 text-[#313647] hover:bg-gray-200' : 'bg-gray-50 text-gray-300 cursor-default' }}"
                            >
                                {{ $letter }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Tropes Liste -->
                    <div class="space-y-4" id="tropes-list">
                        @foreach ($tropes as $trope)
                            <div
                                class="trope-item flex justify-between items-start p-4 bg-gray-50 rounded-lg border border-gray-200"
                                data-label="{{ $trope->label_en }}"
                            >
                                <div>
                                    <span class="text-xs text-gray-400">{{ $trope->identifier }}</span>
                                    <h4 class="font-medium text-[#313647]">
                                        <a href="{{ route('tropes.show', $trope) }}" class="hover:text-[#435663] transition-colors">
                                            {{ $trope->label_en }}
                                        </a>
                                    </h4>
                                    @if ($trope->tvtropes_url)
                                        <p class="text-sm text-[#435663] flex items-center gap-1 mt-1">
                                            <svg class="w-4 h-4 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                            </svg>
                                            <span><i>skos:{{ $trope->tvtropes_mapping ?? 'not defined' }}</i></span>
                                            <a href="{{ $trope->tvtropes_url }}" target="_blank" class="text-blue-600 hover:underline">TV Tropes</a>
                                        </p>
                                    @endif
                                    @if ($trope->wikidata_id)
                                        <p class="text-sm text-[#435663] flex items-center gap-1 mt-1">
                                            <svg class="w-4 h-4 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                            </svg>
                                            <span><i>skos:{{ $trope->wikidata_mapping ?? 'not defined' }}</i></span>
                                            <a href="https://www.wikidata.org/wiki/{{ $trope->wikidata_id }}" target="_blank" class="text-blue-600 hover:underline">Wikidata</a>
                                        </p>
                                    @endif

                                    @if ($trope->description_en)
                                        <p class="text-[#435663] text-sm mt-1">{{ Str::limit($trope->description_en, 200) }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center gap-4">
                                    @auth
                                        <a href="{{ route('tropes.edit', $trope) }}" class="text-blue-600 hover:underline">Edit</a>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Keine Ergebnisse -->
                    <p id="no-results" class="text-gray-400 hidden">No tropes found for this filter.</p>

                    @if ($tropes->isEmpty())
                        <p class="text-gray-400">No tropes defined yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterTropes(filter) {
            const items = document.querySelectorAll('.trope-item');
            let visibleCount = 0;

            items.forEach(item => {
                const label = item.dataset.label;
                const firstChar = label.charAt(0).toUpperCase();
                let show = false;

                if (filter === 'all') {
                    show = true;
                } else if (filter === '#') {
                    // Zeige numerische Einträge (0-9)
                    show = /^[0-9]/.test(label);
                } else {
                    // Zeige Einträge, die mit dem Buchstaben beginnen
                    show = firstChar === filter;
                }

                item.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            // Update Zähler
            document.getElementById('visible-count').textContent = visibleCount;

            // Zeige "keine Ergebnisse" wenn nichts gefunden
            const noResults = document.getElementById('no-results');
            noResults.classList.toggle('hidden', visibleCount > 0);
        }
    </script>
</x-app-layout>
