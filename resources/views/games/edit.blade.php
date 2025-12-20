<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    Edit: {{ $game->title }}
                </h1>
            </div>
        </div>
    </div>

    <!-- Gelber Streifen -->
    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-[#313647]">
                <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span class="font-medium">Edit game details, developers, literature, and vocabulary</span>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('games.update', $game->game_id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-[#313647]">Title</label>
                            <input type="text" name="title" id="title" value="{{ $game->title }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                        </div>

                        <div class="mb-4">
                            <label for="release_year" class="block text-sm font-medium text-[#313647]">Release Date</label>
                            <input type="date" name="release_year" id="release_year" value="{{ $game->release_year }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                        </div>

                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-[#313647] mb-4">Linked Open Data</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="igdb_id" class="block text-sm font-medium text-[#435663]">
                                        <img src="https://www.igdb.com/favicon.ico" width="16" class="inline mr-1"> IGDB ID
                                    </label>
                                    <div class="flex mt-1">
                                        <input type="number" name="igdb_id" id="igdb_id" value="{{ $game->igdb_id }}"
                                               class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <button type="button" onclick="searchIgdb()"
                                                class="bg-[#A3B087] text-[#313647] px-3 py-2 rounded-r-md hover:bg-[#FFF8D4] transition-colors flex items-center" title="Search IGDB">
                                            🔍
                                        </button>
                                    </div>
                                    <div id="igdb-results" class="mt-2 hidden border rounded-md bg-white shadow-lg max-h-60 overflow-y-auto"></div>
                                </div>

                                <div>
                                    <label for="steam_id" class="block text-sm font-medium text-[#435663]">
                                        <img src="https://store.steampowered.com/favicon.ico" width="16" class="inline mr-1"> Steam ID
                                    </label>
                                    <div class="flex mt-1">
                                        <input type="text" name="steam_id" id="steam_id" value="{{ $game->steam_id }}"
                                               class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <a href="https://store.steampowered.com/search/?term={{ urlencode($game->title) }}" target="_blank"
                                           class="bg-[#A3B087] text-[#313647] px-3 py-2 rounded-r-md hover:bg-[#FFF8D4] transition-colors flex items-center" title="Search Steam">
                                            🔍
                                        </a>
                                    </div>
                                </div>

                                <div>
                                    <label for="gog_id" class="block text-sm font-medium text-[#435663]">
                                        <img src="https://www.gog.com/favicon.ico" width="16" class="inline mr-1"> GOG ID
                                    </label>
                                    <div class="flex mt-1">
                                        <input type="text" name="gog_id" id="gog_id" value="{{ $game->gog_id }}"
                                               class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <a href="https://www.gog.com/en/games?query={{ urlencode($game->title) }}" target="_blank"
                                           class="bg-[#A3B087] text-[#313647] px-3 py-2 rounded-r-md hover:bg-[#FFF8D4] transition-colors flex items-center" title="Search GOG">
                                            🔍
                                        </a>
                                    </div>
                                </div>

                                <div>
                                    <label for="wikidata_id" class="block text-sm font-medium text-[#435663]">
                                        <img src="https://www.wikidata.org/favicon.ico" width="16" class="inline mr-1"> Wikidata ID
                                    </label>
                                    <div class="flex mt-1">
                                        <input type="text" name="wikidata_id" id="wikidata_id" value="{{ $game->wikidata_id }}"
                                               class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <button type="button" onclick="searchWikidata()"
                                                class="bg-[#A3B087] text-[#313647] px-3 py-2 rounded-r-md hover:bg-[#FFF8D4] transition-colors flex items-center" title="Search Wikidata">
                                            🔍
                                        </button>
                                    </div>
                                    <div id="wikidata-results" class="mt-2 hidden border rounded-md bg-white shadow-lg max-h-60 overflow-y-auto"></div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-6">

                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-[#313647] mb-4">Developer</h3>

                            <!-- Aktuelle Entwickler -->
                            <div class="mb-4" id="developer-list">
                                @forelse ($developers as $dev)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200" id="dev-row-{{ $dev->id }}">
                                        <div>
                                            <span class="font-medium text-[#313647]">{{ $dev->name }}</span>
                                            @if ($dev->website)
                                                <a href="{{ $dev->website }}" target="_blank" class="text-blue-600 text-sm ml-2">🔗</a>
                                            @endif
                                            @if ($dev->wikidata_id)
                                                <a href="https://www.wikidata.org/wiki/{{ $dev->wikidata_id }}" target="_blank" title="Wikidata" class="ml-1 hover:opacity-70">
                                                    <img src="https://www.wikidata.org/favicon.ico" width="14" class="inline">
                                                </a>
                                            @endif
                                        </div>
                                        <button type="button" onclick="removeDeveloper({{ $dev->id }})" class="text-red-600 hover:text-red-800">
                                            ✕
                                        </button>
                                    </div>
                                @empty
                                    <p class="text-gray-400" id="no-developers">No developer assigned</p>
                                @endforelse
                            </div>

                            <!-- Existierenden Entwickler hinzufügen -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-[#435663] mb-2">Add developer</label>
                                <div class="flex gap-2">
                                    <select id="developer_select" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <option value="">-- Select --</option>
                                        @foreach ($allDevelopers as $dev)
                                            <option value="{{ $dev->id }}">{{ $dev->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="addDeveloper()" class="px-4 py-2 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                        Add
                                    </button>
                                </div>
                            </div>

                            <!-- Neuen Entwickler anlegen -->
                            <div class="border-t border-gray-200 pt-4">
                                <label class="block text-sm font-medium text-[#435663] mb-2">Create new developer</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mb-2">
                                    <input type="text" id="new_dev_name" placeholder="Name" class="rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <input type="text" id="new_dev_website" placeholder="Website (optional)" class="rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <input type="text" id="new_dev_wikidata" placeholder="Wikidata ID (optional)" class="rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                </div>
                                <button type="button" onclick="createDeveloper()" class="px-4 py-2 bg-[#313647] text-white font-semibold rounded-lg hover:bg-[#435663] transition-colors">
                                    Create Developer
                                </button>
                                <span id="dev-create-status" class="ml-2 text-sm"></span>
                            </div>
                        </div>

                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-[#313647] mb-4">Literature</h3>

                            <!-- Aktuelle Literatur -->
                            <div class="mb-4" id="literature-list">
                                @forelse ($literature as $lit)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200" id="lit-row-{{ $lit->literature_id }}">
                                        <div>
                                            <span class="font-medium text-[#313647]">{{ $lit->zotero_id }}</span>
                                        </div>
                                        <button type="button" onclick="removeLiterature({{ $lit->literature_id }})" class="text-red-600 hover:text-red-800">
                                            ✕
                                        </button>
                                    </div>
                                @empty
                                    <p class="text-gray-400" id="no-literature">No literature assigned</p>
                                @endforelse
                            </div>

                            <!-- Literatur suchen und hinzufügen -->
                            <div>
                                <label class="block text-sm font-medium text-[#435663] mb-2">Add literature</label>
                                <div class="flex gap-2">
                                    <input type="text" id="zotero_search" placeholder="Search in Zotero..."
                                           class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <button type="button" onclick="searchZotero()" class="px-4 py-2 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                        Search
                                    </button>
                                </div>
                                <div id="zotero-results" class="mt-2 hidden border rounded-md bg-white shadow-lg max-h-60 overflow-y-auto"></div>
                            </div>
                        </div>

                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-[#313647] mb-4">Vocabulary</h3>

                            <!-- Current Vocabulary -->
                            <div class="mb-4" id="vocabulary-list">
                                @forelse ($vocabularies as $vocab)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200" id="vocab-row-{{ $vocab->voc_id }}">
                                        <div>
                                            <span class="text-xs text-gray-400">{{ $vocab->voc_id }}</span>
                                            <span class="font-medium text-[#313647] ml-2">{{ $vocab->term }}</span>
                                            <span class="text-[#435663] text-sm ml-2">({{ $vocab->category }})</span>
                                        </div>
                                        <button type="button" onclick="removeVocabulary('{{ $vocab->voc_id }}')" class="text-red-600 hover:text-red-800">
                                            ✕
                                        </button>
                                    </div>
                                @empty
                                    <p class="text-gray-400" id="no-vocabulary">No vocabulary assigned</p>
                                @endforelse
                            </div>

                            <!-- Add Vocabulary -->
                            <div>
                                <label class="block text-sm font-medium text-[#435663] mb-2">Add Vocabulary</label>
                                <div class="flex gap-2">
                                    <select id="vocabulary_select" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <option value="">-- Select --</option>
                                        @foreach ($allVocabularies->groupBy('category') as $category => $vocabs)
                                            <optgroup label="{{ $category ?: 'Uncategorized' }}">
                                                @foreach ($vocabs as $vocab)
                                                    <option value="{{ $vocab->voc_id }}" data-term="{{ $vocab->term }}" data-category="{{ $vocab->category }}">
                                                        {{ $vocab->term }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="addVocabulary()" class="px-4 py-2 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between mt-6 sticky bottom-0 bg-white py-4 border-t border-gray-200">
                            <div class="flex space-x-4">
                                <a href="{{ route('games') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-400 text-gray-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="button" onclick="deleteGame()" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Save
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        const gameId = {{ $game->game_id }};
        const csrfToken = '{{ csrf_token() }}';

        async function searchIgdb() {
            const title = document.getElementById('title').value;
            const resultsDiv = document.getElementById('igdb-results');

            if (!title) {
                alert('Enter a title first');
                return;
            }

            resultsDiv.innerHTML = '<div class="p-2 text-gray-500">Searching...</div>';
            resultsDiv.classList.remove('hidden');

            try {
                const response = await fetch(`{{ route('igdb.search') }}?q=${encodeURIComponent(title)}`);
                const results = await response.json();

                if (results.length === 0) {
                    resultsDiv.innerHTML = '<div class="p-2 text-gray-500">No results found</div>';
                    return;
                }

                let html = '';
                results.forEach(game => {
                    html += `
                        <div class="p-2 hover:bg-gray-100 cursor-pointer border-b" onclick="selectIgdb(${game.id})">
                            <span class="font-medium">${game.name}</span>
                            <span class="text-gray-500 text-sm">(${game.year})</span>
                            <span class="text-gray-400 text-xs ml-2">ID: ${game.id}</span>
                        </div>
                    `;
                });
                resultsDiv.innerHTML = html;

            } catch (error) {
                resultsDiv.innerHTML = '<div class="p-2 text-red-500">Error during search</div>';
            }
        }

        function selectIgdb(id) {
            document.getElementById('igdb_id').value = id;
            document.getElementById('igdb-results').classList.add('hidden');
        }

        async function searchWikidata() {
            const title = document.getElementById('title').value;
            const resultsDiv = document.getElementById('wikidata-results');

            if (!title) {
                alert('Enter a title first');
                return;
            }

            resultsDiv.innerHTML = '<div class="p-2 text-gray-500">Searching...</div>';
            resultsDiv.classList.remove('hidden');

            try {
                const response = await fetch(`{{ route('wikidata.search') }}?q=${encodeURIComponent(title)}`);
                const results = await response.json();

                if (results.length === 0) {
                    resultsDiv.innerHTML = '<div class="p-2 text-gray-500">No results found</div>';
                    return;
                }

                let html = '';
                results.forEach(item => {
                    html += `
                        <div class="p-2 hover:bg-gray-100 cursor-pointer border-b" onclick="selectWikidata('${item.id}')">
                            <span class="font-medium">${item.name}</span>
                            <span class="text-gray-400 text-xs ml-2">${item.id}</span>
                            <div class="text-gray-500 text-sm">${item.description}</div>
                        </div>
                    `;
                });
                resultsDiv.innerHTML = html;

            } catch (error) {
                resultsDiv.innerHTML = '<div class="p-2 text-red-500">Error during search</div>';
            }
        }

        function selectWikidata(id) {
            document.getElementById('wikidata_id').value = id;
            document.getElementById('wikidata-results').classList.add('hidden');
        }

        async function addDeveloper() {
            const select = document.getElementById('developer_select');
            const developerId = select.value;
            const developerName = select.options[select.selectedIndex].text;

            if (!developerId) {
                alert('Please select a developer');
                return;
            }

            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/developer`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ developer_id: developerId })
                });

                if (response.ok) {
                    const list = document.getElementById('developer-list');
                    const noDevs = document.getElementById('no-developers');
                    if (noDevs) noDevs.remove();

                    const newRow = document.createElement('div');
                    newRow.className = 'flex justify-between items-center py-2 border-b border-gray-200';
                    newRow.id = `dev-row-${developerId}`;
                    newRow.innerHTML = `
                        <div><span class="font-medium text-[#313647]">${developerName}</span></div>
                        <button type="button" onclick="removeDeveloper(${developerId})" class="text-red-600 hover:text-red-800">✕</button>
                    `;
                    list.appendChild(newRow);

                    select.value = '';
                }
            } catch (error) {
                alert('Error during adding');
            }
        }

        async function removeDeveloper(developerId) {
            if (!confirm('Remove developer?')) return;

            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/developer/${developerId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (response.ok) {
                    document.getElementById(`dev-row-${developerId}`).remove();
                }
            } catch (error) {
                alert('Error during removal');
            }
        }

        async function createDeveloper() {
            const name = document.getElementById('new_dev_name').value;
            const website = document.getElementById('new_dev_website').value;
            const wikidata = document.getElementById('new_dev_wikidata').value;
            const status = document.getElementById('dev-create-status');

            if (!name) {
                alert('Enter a name');
                return;
            }

            try {
                const response = await fetch('{{ route('developer.create') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ name, website, wikidata_id: wikidata })
                });

                const result = await response.json();

                const select = document.getElementById('developer_select');
                const option = new Option(result.name, result.id);
                select.add(option);
                select.value = result.id;

                document.getElementById('new_dev_name').value = '';
                document.getElementById('new_dev_website').value = '';
                document.getElementById('new_dev_wikidata').value = '';

                status.textContent = '✓ Developer created!';
                status.className = 'ml-2 text-sm text-green-600';

            } catch (error) {
                status.textContent = 'Error during creation';
                status.className = 'ml-2 text-sm text-red-600';
            }
        }

        async function searchZotero() {
            const query = document.getElementById('zotero_search').value;
            const resultsDiv = document.getElementById('zotero-results');

            if (!query) {
                alert('Please enter a search term');
                return;
            }

            resultsDiv.innerHTML = '<div class="p-2 text-gray-500">Searching...</div>';
            resultsDiv.classList.remove('hidden');

            try {
                const response = await fetch(`{{ route('zotero.search') }}?q=${encodeURIComponent(query)}`);
                const results = await response.json();

                if (results.length === 0) {
                    resultsDiv.innerHTML = '<div class="p-2 text-gray-500">No results found</div>';
                    return;
                }

                let html = '';
                results.forEach(item => {
                    html += `
                        <div class="p-2 hover:bg-gray-100 cursor-pointer border-b" onclick="addLiterature('${item.key}', '${item.authors} (${item.year})')">
                            <span class="font-medium">${item.title}</span>
                            <div class="text-gray-500 text-sm">${item.authors} (${item.year})</div>
                            <span class="text-gray-400 text-xs">ID: ${item.key}</span>
                        </div>
                    `;
                });
                resultsDiv.innerHTML = html;

            } catch (error) {
                resultsDiv.innerHTML = '<div class="p-2 text-red-500">Error during search</div>';
            }
        }

        async function addLiterature(zoteroId, displayText) {
            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/literature`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ zotero_id: zoteroId })
                });

                if (response.ok) {
                    const list = document.getElementById('literature-list');
                    const noLit = document.getElementById('no-literature');
                    if (noLit) noLit.remove();

                    const newRow = document.createElement('div');
                    newRow.className = 'flex justify-between items-center py-2 border-b border-gray-200';
                    newRow.id = `lit-row-new-${zoteroId}`;
                    newRow.innerHTML = `
                        <div><span class="font-medium text-[#313647]">${zoteroId}</span> - ${displayText}</div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">✕</button>
                    `;
                    list.appendChild(newRow);

                    document.getElementById('zotero_search').value = '';
                    document.getElementById('zotero-results').classList.add('hidden');
                }
            } catch (error) {
                alert('Error during adding');
            }
        }

        async function removeLiterature(literatureId) {
            if (!confirm('Remove literature?')) return;

            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/literature/${literatureId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (response.ok) {
                    document.getElementById(`lit-row-${literatureId}`).remove();
                }
            } catch (error) {
                alert('Error during removal');
            }
        }

        async function deleteGame() {
            if (!confirm('Are you sure you want to delete this game? The links to developers and literature will be removed, but the developers and literature entries themselves will remain in the database.')) {
                return;
            }

            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (response.ok || response.redirected) {
                    window.location.href = '{{ url('/games') }}';
                }
            } catch (error) {
                alert('Error deleting game');
            }
        }

        async function addVocabulary() {
            const select = document.getElementById('vocabulary_select');
            const vocId = select.value;
            const selectedOption = select.options[select.selectedIndex];
            const term = selectedOption.dataset.term;
            const category = selectedOption.dataset.category;

            if (!vocId) {
                alert('Please select a vocabulary entry');
                return;
            }

            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/vocabulary`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ voc_id: vocId })
                });

                if (response.ok) {
                    const list = document.getElementById('vocabulary-list');
                    const noVocab = document.getElementById('no-vocabulary');
                    if (noVocab) noVocab.remove();

                    const newRow = document.createElement('div');
                    newRow.className = 'flex justify-between items-center py-2 border-b border-gray-200';
                    newRow.id = `vocab-row-${vocId}`;
                    newRow.innerHTML = `
                        <div>
                            <span class="text-xs text-gray-400">${vocId}</span>
                            <span class="font-medium text-[#313647] ml-2">${term}</span>
                            <span class="text-[#435663] text-sm ml-2">(${category})</span>
                        </div>
                        <button type="button" onclick="removeVocabulary('${vocId}')" class="text-red-600 hover:text-red-800">✕</button>
                    `;
                    list.appendChild(newRow);

                    select.value = '';
                }
            } catch (error) {
                alert('Error adding vocabulary');
            }
        }

        async function removeVocabulary(vocId) {
            if (!confirm('Remove this vocabulary entry?')) return;

            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/vocabulary/${vocId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (response.ok) {
                    document.getElementById(`vocab-row-${vocId}`).remove();
                }
            } catch (error) {
                alert('Error removing vocabulary');
            }
        }
    </script>
</x-app-layout>
