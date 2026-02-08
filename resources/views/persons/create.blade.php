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
                    <form method="POST" action="{{ route('persons.store') }}">
                        @csrf

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Basic Information</h3>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="identifier" class="block text-sm font-medium text-[#313647]">Identifier</label>
                                    <input type="text" name="identifier" id="identifier" required placeholder="e.g. ramesses-ii"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <p class="text-sm text-[#435663] mt-1">Use lowercase with hyphens</p>
                                </div>
                                <div>
                                    <label for="label_en" class="block text-sm font-medium text-[#313647]">Name (English)</label>
                                    <input type="text" name="label_en" id="label_en" required placeholder="e.g. Ramesses II"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="description_en" class="block text-sm font-medium text-[#313647]">Description</label>
                                <textarea name="description_en" id="description_en" rows="3"
                                          placeholder="Brief biographical information and historical context..."
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]"></textarea>
                            </div>

                            <!-- Legendary Checkbox -->
                            <div class="mb-6">
                                <label class="flex items-center">
                                    <input type="checkbox" name="legendary" id="legendary" value="1"
                                           class="rounded border-gray-300 text-[#A3B087] shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <span class="ml-2 text-sm text-[#313647]">
                                        <strong>Legendary Figure</strong> – This person is mythological or legendary, not historically verified
                                    </span>
                                </label>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="birth_year" class="block text-sm font-medium text-[#313647]">Birth Year</label>
                                    <input type="number" name="birth_year" id="birth_year" placeholder="e.g. -1303"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <p class="text-sm text-[#435663] mt-1">Use negative for BCE</p>
                                    <label class="flex items-center mt-2">
                                        <input type="checkbox" name="birth_year_uncertain" id="birth_year_uncertain" value="1"
                                               class="rounded border-gray-300 text-[#A3B087] shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <span class="ml-2 text-sm text-[#435663]">Date uncertain (ca.)</span>
                                    </label>
                                </div>
                                <div>
                                    <label for="death_year" class="block text-sm font-medium text-[#313647]">Death Year</label>
                                    <input type="number" name="death_year" id="death_year" placeholder="e.g. -1213"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <p class="text-sm text-[#435663] mt-1">Use negative for BCE</p>
                                    <label class="flex items-center mt-2">
                                        <input type="checkbox" name="death_year_uncertain" id="death_year_uncertain" value="1"
                                               class="rounded border-gray-300 text-[#A3B087] shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <span class="ml-2 text-sm text-[#435663]">Date uncertain (ca.)</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Linked Open Data -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Linked Open Data</h3>

                            <!-- GND -->
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <div class="col-span-2">
                                    <label for="gnd_id" class="block text-sm font-medium text-[#313647]">GND ID</label>
                                    <input type="text" name="gnd_id" id="gnd_id" placeholder="e.g. 118598461"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <p class="text-xs text-[#435663] mt-1">Find IDs at <a href="https://lobid.org/gnd" target="_blank" class="text-blue-600 hover:underline">lobid.org/gnd</a></p>
                                </div>
                                <div>
                                    <label for="gnd_mapping" class="block text-sm font-medium text-[#313647]">SKOS Mapping</label>
                                    <select name="gnd_mapping" id="gnd_mapping"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <option value="">-- Select --</option>
                                        @foreach ($mappingTypes as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Wikidata -->
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <label for="wikidata_id" class="block text-sm font-medium text-[#313647]">Wikidata ID</label>
                                    <input type="text" name="wikidata_id" id="wikidata_id" placeholder="e.g. Q1523"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <p class="text-xs text-[#435663] mt-1">Find IDs at <a href="https://www.wikidata.org" target="_blank" class="text-blue-600 hover:underline">wikidata.org</a></p>
                                </div>
                                <div>
                                    <label for="wikidata_mapping" class="block text-sm font-medium text-[#313647]">SKOS Mapping</label>
                                    <select name="wikidata_mapping" id="wikidata_mapping"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <option value="">-- Select --</option>
                                        @foreach ($mappingTypes as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Alternative Names -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Alternative Names</h3>
                            <div id="alternative-names-container">
                                <p id="no-alt-names" class="text-gray-500 text-sm mb-2">No alternative names yet.</p>
                            </div>

                            <button type="button" onclick="addAltName()" class="mt-2 inline-flex items-center px-3 py-1 border border-[#A3B087] text-[#313647] text-sm rounded hover:bg-[#A3B087]/20">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add Alternative Name
                            </button>
                        </div>

                        <!-- Buttons -->
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
        let altNameIndex = 0;

        function addAltName() {
            document.getElementById('no-alt-names')?.remove();

            const container = document.getElementById('alternative-names-container');
            const row = document.createElement('div');
            row.className = 'alt-name-row grid grid-cols-12 gap-2 mb-2';
            row.innerHTML = `
                <div class="col-span-8">
                    <input type="text" name="alternative_names[${altNameIndex}][name]" placeholder="Alternative name"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                </div>
                <div class="col-span-3">
                    <select name="alternative_names[${altNameIndex}][language]"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                        <option value="en">English</option>
                        <option value="de">German</option>
                        <option value="la">Latin</option>
                        <option value="grc">Ancient Greek</option>
                        <option value="ar">Arabic</option>
                        <option value="he">Hebrew</option>
                    </select>
                </div>
                <div class="col-span-1 flex items-center">
                    <button type="button" onclick="removeAltName(this)" class="text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            `;
            container.appendChild(row);
            altNameIndex++;
        }

        function removeAltName(button) {
            button.closest('.alt-name-row').remove();

            // Zeige "No alternative names" wieder an, wenn keine mehr da sind
            const container = document.getElementById('alternative-names-container');
            if (container.querySelectorAll('.alt-name-row').length === 0) {
                const noNamesMsg = document.createElement('p');
                noNamesMsg.id = 'no-alt-names';
                noNamesMsg.className = 'text-gray-500 text-sm mb-2';
                noNamesMsg.textContent = 'No alternative names yet.';
                container.appendChild(noNamesMsg);
            }
        }
    </script>
</x-app-layout>
