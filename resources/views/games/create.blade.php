<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    Create New Game
                </h1>
            </div>
        </div>
    </div>

    <!-- Gelber Streifen -->
    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-[#313647]">
                <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="font-medium">Add a new game to the archive</span>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('games.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-[#313647]">Title</label>
                            <input type="text" name="title" id="title" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                        </div>

                        <div class="mb-4">
                            <label for="release_year" class="block text-sm font-medium text-[#313647]">Release Date</label>
                            <input type="date" name="release_year" id="release_year"
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
                                        <input type="number" name="igdb_id" id="igdb_id"
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
                                    <input type="text" name="steam_id" id="steam_id"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                </div>

                                <div>
                                    <label for="gog_id" class="block text-sm font-medium text-[#435663]">
                                        <img src="https://www.gog.com/favicon.ico" width="16" class="inline mr-1"> GOG ID
                                    </label>
                                    <input type="text" name="gog_id" id="gog_id"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                </div>

                                <div>
                                    <label for="wikidata_id" class="block text-sm font-medium text-[#435663]">
                                        <img src="https://www.wikidata.org/favicon.ico" width="16" class="inline mr-1"> Wikidata ID
                                    </label>
                                    <div class="flex mt-1">
                                        <input type="text" name="wikidata_id" id="wikidata_id"
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

                        <p class="text-sm text-[#435663] mb-4">
                            Developer(s) and literature can be added after creating the new entry.
                        </p>

                        <div class="flex justify-between mt-6">
                            <a href="{{ route('games') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-400 text-gray-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Create
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        async function searchIgdb() {
            const title = document.getElementById('title').value;
            const resultsDiv = document.getElementById('igdb-results');

            if (!title) {
                alert('Please enter title first');
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
                alert('Please enter title first');
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
    </script>
</x-app-layout>
