<x-app-layout>
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">Historical Persons</h1>
                @auth
                    <a href="{{ route('persons.create') }}" class="inline-flex items-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Person
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-[#313647]">
                <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="font-medium"><span id="visible-count">{{ $persons->count() }}</span> Persons</span>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6">

                    <!-- Alphabetischer Filter -->
                    @php
                        // Sammle alle Anfangsbuchstaben der Persons
                        $availableLetters = $persons->map(function($person) {
                            $firstChar = strtoupper(substr($person->label_en, 0, 1));
                            return ctype_alpha($firstChar) ? $firstChar : '#';
                        })->unique()->toArray();
                    @endphp

                    <div class="mb-6 flex flex-wrap gap-1 justify-center" x-data="{ activeFilter: 'all' }">
                        <button
                            @click="activeFilter = 'all'; filterPersons('all')"
                            :class="activeFilter === 'all' ? 'bg-[#313647] text-[#FFF8D4]' : 'bg-gray-100 text-[#313647] hover:bg-gray-200'"
                            class="px-3 py-1 rounded text-sm font-medium transition-colors"
                        >
                            All
                        </button>
                        <button
                            @click="@if(in_array('#', $availableLetters))activeFilter = '#'; filterPersons('#')@endif"
                            :class="activeFilter === '#' ? 'bg-[#313647] text-[#FFF8D4]' : ''"
                            class="px-3 py-1 rounded text-sm font-medium transition-colors {{ in_array('#', $availableLetters) ? 'bg-gray-100 text-[#313647] hover:bg-gray-200' : 'bg-gray-50 text-gray-300 cursor-default' }}"
                        >
                            #
                        </button>
                        @foreach (range('A', 'Z') as $letter)
                            <button
                                @click="@if(in_array($letter, $availableLetters))activeFilter = '{{ $letter }}'; filterPersons('{{ $letter }}')@endif"
                                :class="activeFilter === '{{ $letter }}' ? 'bg-[#313647] text-[#FFF8D4]' : ''"
                                class="px-3 py-1 rounded text-sm font-medium transition-colors {{ in_array($letter, $availableLetters) ? 'bg-gray-100 text-[#313647] hover:bg-gray-200' : 'bg-gray-50 text-gray-300 cursor-default' }}"
                            >
                                {{ $letter }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Persons Liste -->
                    @if ($persons->count() > 0)
                        <div class="space-y-4" id="persons-list">
                            @foreach ($persons as $person)
                                <div
                                    class="person-item flex justify-between items-start p-4 bg-gray-50 rounded-lg border border-gray-200"
                                    data-label="{{ $person->label_en }}"
                                >
                                    <div class="flex-1">
                                        <span class="text-xs text-gray-400">{{ $person->identifier }}</span>
                                        <h4 class="font-medium text-[#313647]">
                                            <a href="{{ route('persons.show', $person) }}" class="hover:text-[#435663] transition-colors">
                                                {{ $person->label_en }}
                                            </a>
                                        </h4>
                                        @if ($person->lifespan)
                                            <p class="text-sm text-[#435663]">{{ $person->lifespan }}</p>
                                        @endif
                                        @if ($person->description_en)
                                            <p class="text-[#435663] text-sm mt-1">{{ Str::limit($person->description_en, 200) }}</p>
                                        @endif
                                        <div class="flex gap-4 mt-2">
                                            @if ($person->gnd_id)
                                                <a href="https://d-nb.info/gnd/{{ $person->gnd_id }}" target="_blank" class="text-xs text-blue-600 hover:underline">GND</a>
                                            @endif
                                            @if ($person->wikidata_id)
                                                <a href="https://www.wikidata.org/wiki/{{ $person->wikidata_id }}" target="_blank" class="text-xs text-blue-600 hover:underline">Wikidata</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="text-sm text-gray-500">{{ $person->games->count() }} games</span>
                                        @auth
                                            <a href="{{ route('persons.edit', $person) }}" class="text-blue-600 hover:underline">Edit</a>
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Keine Ergebnisse -->
                        <p id="no-results" class="text-gray-400 hidden">No persons found for this filter.</p>
                    @else
                        <p class="text-gray-400">No persons defined yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterPersons(filter) {
            const items = document.querySelectorAll('.person-item');
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
