<x-app-layout>
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">New Historical Person</h1>
            </div>
        </div>
    </div>

    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-[#313647]">
                <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="font-medium">Add a new historical person to the vocabulary</span>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <!-- GND Search -->
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="text-sm font-semibold text-blue-800 mb-2">Search GND (German National Library)</h3>
                        <div class="flex gap-2">
                            <input type="text" id="gnd-search" placeholder="Search for a person..."
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                            <button type="button" onclick="searchGnd()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Search
                            </button>
                        </div>
                        <div id="gnd-results" class="mt-2 hidden">
                            <div class="space-y-2" id="gnd-results-list"></div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('persons.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="identifier" class="block text-sm font-medium text-[#313647]">Identifier</label>
                            <input type="text" name="identifier" id="identifier" required placeholder="e.g. ramesses-ii"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                            <p class="text-sm text-[#435663] mt-1">Use lowercase with hyphens</p>
                        </div>

                        <div class="mb-4">
                            <label for="label_en" class="block text-sm font-medium text-[#313647]">Name</label>
                            <input type="text" name="label_en" id="label_en" required placeholder="e.g. Ramesses II"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                        </div>

                        <div class="mb-4">
                            <label for="description_en" class="block text-sm font-medium text-[#313647]">Description (English)</label>
                            <textarea name="description_en" id="description_en" rows="4"
                                      placeholder="Brief biographical information and historical context..."
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="birth_year" class="block text-sm font-medium text-[#313647]">Birth Year</label>
                                <input type="number" name="birth_year" id="birth_year" placeholder="e.g. -1303"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                <p class="text-sm text-[#435663] mt-1">Use negative for BCE</p>
                            </div>
                            <div>
                                <label for="death_year" class="block text-sm font-medium text-[#313647]">Death Year</label>
                                <input type="number" name="death_year" id="death_year" placeholder="e.g. -1213"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                <p class="text-sm text-[#435663] mt-1">Use negative for BCE</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="gnd_id" class="block text-sm font-medium text-[#313647]">GND ID</label>
                                <input type="text" name="gnd_id" id="gnd_id" placeholder="e.g. 118598461"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                            </div>
                            <div>
                                <label for="wikidata_id" class="block text-sm font-medium text-[#313647]">Wikidata ID</label>
                                <input type="text" name="wikidata_id" id="wikidata_id" placeholder="e.g. Q1523"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                            </div>
                        </div>

                        <div class="flex justify-between mt-6">
                            <a href="{{ route('persons.index') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-400 text-gray-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
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
        function searchGnd() {
            const query = document.getElementById('gnd-search').value;
            if (!query) return;

            fetch(`{{ route('persons.gnd-search') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    const resultsDiv = document.getElementById('gnd-results');
                    const listDiv = document.getElementById('gnd-results-list');
                    listDiv.innerHTML = '';

                    if (data.length === 0) {
                        listDiv.innerHTML = '<p class="text-gray-500 text-sm">No results found.</p>';
                    } else {
                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.className = 'p-2 bg-white rounded border border-gray-200 cursor-pointer hover:bg-gray-50';
                            div.innerHTML = `<strong>${item.name}</strong><br><span class="text-xs text-gray-500">${item.description || ''}</span>`;
                            div.onclick = () => selectGndResult(item);
                            listDiv.appendChild(div);
                        });
                    }

                    resultsDiv.classList.remove('hidden');
                });
        }

        function selectGndResult(item) {
            document.getElementById('gnd_id').value = item.gnd_id || '';
            // Extract name without lifespan
            const name = item.name.replace(/\s*\([^)]*\)\s*$/, '');
            document.getElementById('label_en').value = name;
            // Generate identifier
            document.getElementById('identifier').value = name.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            document.getElementById('gnd-results').classList.add('hidden');
        }
    </script>
</x-app-layout>
