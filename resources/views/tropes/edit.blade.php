<x-app-layout>
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">Edit Trope</h1>
            </div>
        </div>
    </div>

    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-[#313647]">
                <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span class="font-medium">{{ $trope->label_en }}</span>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('tropes.update', $trope) }}">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Basic Information</h3>

                            <div class="mb-4">
                                <label for="identifier" class="block text-sm font-medium text-[#313647]">Identifier</label>
                                <input type="text" name="identifier" id="identifier" required value="{{ $trope->identifier }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                            </div>

                            <div class="mb-4">
                                <label for="label_en" class="block text-sm font-medium text-[#313647]">Label (English)</label>
                                <input type="text" name="label_en" id="label_en" required value="{{ $trope->label_en }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                            </div>

                            <div class="mb-4">
                                <label for="description_en" class="block text-sm font-medium text-[#313647]">Description (English)</label>
                                <textarea name="description_en" id="description_en" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">{{ $trope->description_en }}</textarea>
                            </div>
                        </div>

                        <!-- Linked Open Data -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Linked Open Data</h3>

                            <!-- TV Tropes (special case: full URL) -->
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <div class="col-span-2">
                                    <label for="tvtropes_url" class="block text-sm font-medium text-[#313647]">TV Tropes URL</label>
                                    <input type="url" name="tvtropes_url" id="tvtropes_url" value="{{ $trope->tvtropes_url }}" placeholder="https://tvtropes.org/pmwiki/pmwiki.php/Main/..."
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    @if ($trope->tvtropes_url)
                                        <a href="{{ $trope->tvtropes_url }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">View on TV Tropes ↗</a>
                                    @endif
                                </div>
                                <div>
                                    <label for="tvtropes_mapping" class="block text-sm font-medium text-[#313647]">SKOS Mapping</label>
                                    <select name="tvtropes_mapping" id="tvtropes_mapping"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <option value="">-- Select --</option>
                                        @foreach ($mappingTypes as $type)
                                            <option value="{{ $type }}" {{ $trope->tvtropes_mapping === $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @include('partials.lod-field', [
                                'name' => 'wikidata',
                                'label' => 'Wikidata',
                                'value' => $trope->wikidata_id,
                                'mappingValue' => $trope->wikidata_mapping,
                                'mappingTypes' => $mappingTypes,
                                'urlPrefix' => 'https://www.wikidata.org/wiki/',
                                'placeholder' => 'e.g. Q5432'
                            ])
                        </div>

                        <!-- Alternative Names -->
                        @include('partials.alternative-names', [
                            'alternativeNames' => $trope->alternativeNames
                        ])

                        <div class="flex justify-between mt-6">
                            <div class="flex gap-2">
                                <a href="{{ route('tropes.index') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-400 text-gray-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="button" onclick="deleteTrope()" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
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
        function deleteTrope() {
            if (confirm('Are you sure you want to delete this trope?')) {
                fetch('{{ route('tropes.destroy', $trope) }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                }).then(response => {
                    if (response.ok) {
                        window.location.href = '{{ route('tropes.index') }}';
                    }
                });
            }
        }
    </script>
</x-app-layout>
