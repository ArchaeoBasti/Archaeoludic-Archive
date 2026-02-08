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

                    <!-- Suchfeld -->
                    <div class="mb-6">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="search-input"
                                placeholder="Search persons by name, description, or alternative names..."
                                onkeyup="searchPersons()"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-[#A3B087] focus:border-[#A3B087] sm:text-sm"
                            >
                        </div>
                    </div>

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
                                    data-description="{{ $person->description_en }}"
                                    data-alternative-names="{{ $person->alternativeNames->pluck('name')->implode('|') }}"
                                >
                                    <div class="flex-1">
                                        <span class="text-xs text-gray-400">{{ $person->identifier }}</span>
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-medium text-[#313647]">
                                                <a href="{{ route('persons.show', $person) }}" class="hover:text-[#435663] transition-colors">
                                                    {{ $person->label_en }}
                                                </a>
                                            </h4>
                                            @if ($person->legendary)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                                    </svg>
                                                    Legendary
                                                </span>
                                            @endif
                                        </div>
                                        @if ($person->birth_year || $person->death_year)
                                          <p class="text-sm text-[#435663] flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-[#435663]">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
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
                                          </p>
                                        @endif

                                        @if ($person->gnd_id)
                                            <p class="text-sm text-[#435663] flex items-center gap-1 mt-1">
                                                <svg class="w-4 h-4 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                </svg>
                                                <span><i>skos:{{ $person->gnd_mapping ?? 'not defined' }}</i></span>
                                                <a href="https://d-nb.info/gnd/{{ $person->gnd_id }}" target="_blank" class="text-blue-600 hover:underline">GND</a>
                                            </p>
                                        @endif
                                        @if ($person->wikidata_id)
                                            <p class="text-sm text-[#435663] flex items-center gap-1 mt-1">
                                                <svg class="w-4 h-4 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                </svg>
                                                <span><i>skos:{{ $person->wikidata_mapping ?? 'not defined' }}</i></span>
                                                <a href="https://www.wikidata.org/wiki/{{ $person->wikidata_id }}" target="_blank" class="text-blue-600 hover:underline">Wikidata</a>
                                            </p>
                                        @endif

                                        @if ($person->description_en)
                                            <p class="text-[#435663] text-sm mt-1">{{ Str::limit($person->description_en, 200) }}</p>
                                        @endif
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
        let currentLetterFilter = 'all';

        function searchPersons() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const items = document.querySelectorAll('.person-item');
            let visibleCount = 0;

            items.forEach(item => {
                const label = item.dataset.label.toLowerCase();
                const description = item.dataset.description.toLowerCase();
                const altNames = item.dataset.alternativeNames.toLowerCase();

                // Kombiniere alle durchsuchbaren Felder
                const searchableText = label + ' ' + description + ' ' + altNames;

                // Prüfe ob der Suchbegriff vorkommt
                const matchesSearch = searchTerm === '' || searchableText.includes(searchTerm);

                // Prüfe ob der Buchstabenfilter passt
                const firstChar = item.dataset.label.charAt(0).toUpperCase();
                let matchesLetter = false;

                if (currentLetterFilter === 'all') {
                    matchesLetter = true;
                } else if (currentLetterFilter === '#') {
                    matchesLetter = /^[0-9]/.test(item.dataset.label);
                } else {
                    matchesLetter = firstChar === currentLetterFilter;
                }

                // Zeige nur wenn beide Filter passen
                const show = matchesSearch && matchesLetter;

                item.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            // Update Zähler
            document.getElementById('visible-count').textContent = visibleCount;

            // Zeige "keine Ergebnisse" wenn nichts gefunden
            const noResults = document.getElementById('no-results');
            noResults.classList.toggle('hidden', visibleCount > 0);
        }

        function filterPersons(filter) {
            currentLetterFilter = filter;
            searchPersons(); // Rufe die Suchfunktion auf, die beide Filter kombiniert
        }
    </script>
</x-app-layout>
