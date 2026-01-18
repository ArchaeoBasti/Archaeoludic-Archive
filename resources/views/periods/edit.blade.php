<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    Edit: {{ $period->label_en }}
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
                <span class="font-medium">Edit period details</span>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('periods.update', $period) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="identifier" class="block text-sm font-medium text-[#313647]">Identifier</label>
                            <input type="text" name="identifier" id="identifier" value="{{ $period->identifier }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                        </div>

                        <div class="mb-4">
                            <label for="label_en" class="block text-sm font-medium text-[#313647]">Label (English)</label>
                            <input type="text" name="label_en" id="label_en" value="{{ $period->label_en }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                        </div>

                        <div class="mb-4">
                            <label for="description_en" class="block text-sm font-medium text-[#313647]">Description (English)</label>
                            <textarea name="description_en" id="description_en" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">{{ $period->description_en }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="parent_id" class="block text-sm font-medium text-[#313647]">Parent Period (optional)</label>
                            <select name="parent_id" id="parent_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                <option value="">— None (Top-Level) —</option>
                                @foreach ($parentOptions->whereNull('parent_id') as $topLevel)
                                    <option value="{{ $topLevel->id }}" {{ $period->parent_id == $topLevel->id ? 'selected' : '' }}>
                                        {{ $topLevel->label_en }}
                                    </option>
                                    @foreach ($parentOptions->where('parent_id', $topLevel->id) as $child)
                                        <option value="{{ $child->id }}" {{ $period->parent_id == $child->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;&nbsp;└ {{ $child->label_en }}
                                        </option>
                                        @foreach ($parentOptions->where('parent_id', $child->id) as $grandchild)
                                            <option value="{{ $grandchild->id }}" {{ $period->parent_id == $grandchild->id ? 'selected' : '' }}>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ {{ $grandchild->label_en }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="start_year" class="block text-sm font-medium text-[#313647]">Start Year</label>
                                <input type="number" name="start_year" id="start_year" value="{{ $period->start_year }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                <p class="text-sm text-[#435663] mt-1">Use negative numbers for BCE</p>
                            </div>
                            <div>
                                <label for="end_year" class="block text-sm font-medium text-[#313647]">End Year</label>
                                <input type="number" name="end_year" id="end_year" value="{{ $period->end_year }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                <p class="text-sm text-[#435663] mt-1">Use negative numbers for BCE</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="start_uncertain" id="start_uncertain" value="1"
                                       {{ $period->start_uncertain ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-[#A3B087] focus:ring-[#A3B087]">
                                <label for="start_uncertain" class="ml-2 text-sm text-[#313647]">Start date uncertain</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="end_uncertain" id="end_uncertain" value="1"
                                       {{ $period->end_uncertain ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-[#A3B087] focus:ring-[#A3B087]">
                                <label for="end_uncertain" class="ml-2 text-sm text-[#313647]">End date uncertain</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="color" class="block text-sm font-medium text-[#313647]">Color (for Top-Level only)</label>
                            <div class="flex items-center gap-3 mt-1">
                                <input type="color" name="color" id="color" value="{{ $period->color ?? '#313647' }}"
                                       class="h-10 w-20 rounded border-gray-300 cursor-pointer">
                                <input type="text" id="color_hex" value="{{ $period->color ?? '#313647' }}" maxlength="7"
                                       class="w-24 rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087] font-mono text-sm"
                                       oninput="document.getElementById('color').value = this.value">
                                <span class="text-sm text-[#435663]">Only applies to top-level periods</span>
                            </div>
                            <script>
                                document.getElementById('color').addEventListener('input', function() {
                                    document.getElementById('color_hex').value = this.value;
                                });
                            </script>
                        </div>

                        <!-- Linked Open Data -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Linked Open Data</h3>

                            @include('partials.lod-field', [
                                'name' => 'wikidata',
                                'label' => 'Wikidata',
                                'value' => $period->wikidata_id,
                                'mappingValue' => $period->wikidata_mapping,
                                'mappingTypes' => $mappingTypes,
                                'urlPrefix' => 'https://www.wikidata.org/wiki/',
                                'placeholder' => 'e.g. Q11764'
                            ])
                        </div>

                        <!-- Alternative Names -->
                        @include('partials.alternative-names', [
                            'alternativeNames' => $period->alternativeNames
                        ])

                        <div class="flex justify-between mt-6">
                            <div class="flex space-x-4">
                                <a href="{{ route('periods.index') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-400 text-gray-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="button" onclick="deletePeriod()" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
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
        async function deletePeriod() {
            if (!confirm('Are you sure you want to delete this period? Links to games will also be removed.')) {
                return;
            }

            try {
                const response = await fetch('{{ route('periods.destroy', $period) }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (response.ok) {
                    window.location.href = '{{ route('periods.index') }}';
                }
            } catch (error) {
                alert('Error deleting period');
            }
        }
    </script>
</x-app-layout>
