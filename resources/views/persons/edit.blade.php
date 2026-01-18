<x-app-layout>
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">Edit Person</h1>
            </div>
        </div>
    </div>

    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-[#313647]">
                <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span class="font-medium">{{ $person->label_en }}</span>
                @if ($person->lifespan)
                    <span class="text-[#435663]">({{ $person->lifespan }})</span>
                @endif
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('persons.update', $person) }}">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Basic Information</h3>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="identifier" class="block text-sm font-medium text-[#313647]">Identifier</label>
                                    <input type="text" name="identifier" id="identifier" value="{{ $person->identifier }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                </div>
                                <div>
                                    <label for="label_en" class="block text-sm font-medium text-[#313647]">Name (English)</label>
                                    <input type="text" name="label_en" id="label_en" value="{{ $person->label_en }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="description_en" class="block text-sm font-medium text-[#313647]">Description</label>
                                <textarea name="description_en" id="description_en" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">{{ $person->description_en }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="birth_year" class="block text-sm font-medium text-[#313647]">Birth Year</label>
                                    <input type="number" name="birth_year" id="birth_year" value="{{ $person->birth_year }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <p class="text-sm text-[#435663] mt-1">Use negative for BCE</p>
                                </div>
                                <div>
                                    <label for="death_year" class="block text-sm font-medium text-[#313647]">Death Year</label>
                                    <input type="number" name="death_year" id="death_year" value="{{ $person->death_year }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <p class="text-sm text-[#435663] mt-1">Use negative for BCE</p>
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
                                    <input type="text" name="gnd_id" id="gnd_id" value="{{ $person->gnd_id }}" placeholder="e.g. 118598461"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    @if ($person->gnd_id)
                                        <a href="https://d-nb.info/gnd/{{ $person->gnd_id }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">View in GND ↗</a>
                                    @endif
                                </div>
                                <div>
                                    <label for="gnd_mapping" class="block text-sm font-medium text-[#313647]">SKOS Mapping</label>
                                    <select name="gnd_mapping" id="gnd_mapping"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <option value="">-- Select --</option>
                                        @foreach ($mappingTypes as $type)
                                            <option value="{{ $type }}" {{ $person->gnd_mapping === $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Wikidata -->
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <label for="wikidata_id" class="block text-sm font-medium text-[#313647]">Wikidata ID</label>
                                    <input type="text" name="wikidata_id" id="wikidata_id" value="{{ $person->wikidata_id }}" placeholder="e.g. Q1523"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    @if ($person->wikidata_id)
                                        <a href="https://www.wikidata.org/wiki/{{ $person->wikidata_id }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">View in Wikidata ↗</a>
                                    @endif
                                </div>
                                <div>
                                    <label for="wikidata_mapping" class="block text-sm font-medium text-[#313647]">SKOS Mapping</label>
                                    <select name="wikidata_mapping" id="wikidata_mapping"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <option value="">-- Select --</option>
                                        @foreach ($mappingTypes as $type)
                                            <option value="{{ $type }}" {{ $person->wikidata_mapping === $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Alternative Names -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Alternative Names</h3>

                            <div id="alternative-names-container">
                                @forelse ($person->alternativeNames as $index => $altName)
                                    <div class="alt-name-row grid grid-cols-12 gap-2 mb-2">
                                        <div class="col-span-8">
                                            <input type="text" name="alternative_names[{{ $index }}][name]" value="{{ $altName->name }}" placeholder="Alternative name"
                                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        </div>
                                        <div class="col-span-3">
                                            <select name="alternative_names[{{ $index }}][language]"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                                <option value="en" {{ $altName->language === 'en' ? 'selected' : '' }}>English</option>
                                                <option value="de" {{ $altName->language === 'de' ? 'selected' : '' }}>German</option>
                                                <option value="la" {{ $altName->language === 'la' ? 'selected' : '' }}>Latin</option>
                                                <option value="grc" {{ $altName->language === 'grc' ? 'selected' : '' }}>Ancient Greek</option>
                                                <option value="ar" {{ $altName->language === 'ar' ? 'selected' : '' }}>Arabic</option>
                                                <option value="he" {{ $altName->language === 'he' ? 'selected' : '' }}>Hebrew</option>
                                            </select>
                                        </div>
                                        <div class="col-span-1 flex items-center">
                                            <button type="button" onclick="removeAltName(this)" class="text-red-600 hover:text-red-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <p id="no-alt-names" class="text-gray-500 text-sm mb-2">No alternative names yet.</p>
                                @endforelse
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
                            <a href="{{ route('persons.show', $person) }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-400 text-gray-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Cancel
                            </a>
                            <div class="flex gap-4">
                                @auth
                                    <button type="button" onclick="deletePerson()" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                @endauth
                                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let altNameIndex = {{ $person->alternativeNames->count() }};

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
        }

        function deletePerson() {
            if (confirm('Are you sure you want to delete this person? This action cannot be undone.')) {
                fetch('{{ route('persons.destroy', $person) }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                }).then(response => {
                    if (response.ok) {
                        window.location.href = '{{ route('persons.index') }}';
                    }
                });
            }
        }
    </script>
</x-app-layout>
