<x-app-layout>
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">New Place</h1>
        </div>
    </div>

    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="font-medium text-[#313647]">Add a new place to the vocabulary</span>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('places.store') }}">
                        @csrf

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Basic Information</h3>

                            <div class="mb-4">
                                <label for="identifier" class="block text-sm font-medium text-[#313647]">Identifier</label>
                                <input type="text" name="identifier" id="identifier" required placeholder="e.g. ancient-egypt"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                <p class="text-sm text-[#435663] mt-1">Use lowercase with hyphens</p>
                            </div>

                            <div class="mb-4">
                                <label for="label_en" class="block text-sm font-medium text-[#313647]">Label (English)</label>
                                <input type="text" name="label_en" id="label_en" required placeholder="e.g. Ancient Egypt"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                            </div>

                            <div class="mb-4">
                                <label for="description_en" class="block text-sm font-medium text-[#313647]">Description (English)</label>
                                <textarea name="description_en" id="description_en" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]"></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="parent_id" class="block text-sm font-medium text-[#313647]">Parent Place (optional)</label>
                                <select name="parent_id" id="parent_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <option value="">— None (Top-Level) —</option>
                                    @foreach ($parentOptions->whereNull('parent_id') as $topLevel)
                                        <option value="{{ $topLevel->id }}">
                                            {{ $topLevel->label_en }}
                                        </option>
                                        @foreach ($parentOptions->where('parent_id', $topLevel->id) as $child)
                                            <option value="{{ $child->id }}">
                                                &nbsp;&nbsp;&nbsp;└ {{ $child->label_en }}
                                            </option>
                                            @foreach ($parentOptions->where('parent_id', $child->id) as $grandchild)
                                                <option value="{{ $grandchild->id }}">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ {{ $grandchild->label_en }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Coordinates -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Coordinates</h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="latitude" class="block text-sm font-medium text-[#313647]">Latitude</label>
                                    <input type="number" step="any" name="latitude" id="latitude" placeholder="e.g. 29.9792"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                </div>
                                <div>
                                    <label for="longitude" class="block text-sm font-medium text-[#313647]">Longitude</label>
                                    <input type="number" step="any" name="longitude" id="longitude" placeholder="e.g. 31.1342"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                </div>
                            </div>
                        </div>

                        <!-- Linked Open Data -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Linked Open Data</h3>

                            <!-- Getty TGN -->
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <label for="tgn_id" class="block text-sm font-medium text-[#313647]">Getty TGN ID</label>
                                    <input type="text" name="tgn_id" id="tgn_id" placeholder="e.g. 7004474"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <p class="text-xs text-[#435663] mt-1">Find IDs at <a href="https://www.getty.edu/research/tools/vocabularies/tgn/" target="_blank" class="text-blue-600 hover:underline">Getty TGN</a></p>
                                </div>
                                <div>
                                    <label for="tgn_mapping" class="block text-sm font-medium text-[#313647]">SKOS Mapping</label>
                                    <select name="tgn_mapping" id="tgn_mapping"
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
                            <a href="{{ route('places.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-gray-400 text-gray-600 font-semibold rounded-lg hover:bg-gray-100">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4]">
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
                        <option value="fr">French</option>
                        <option value="es">Spanish</option>
                        <option value="it">Italian</option>
                        <option value="la">Latin</option>
                        <option value="grc">Ancient Greek</option>
                        <option value="ar">Arabic</option>
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
