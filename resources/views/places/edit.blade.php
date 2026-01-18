<x-app-layout>
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">Edit: {{ $place->label_en }}</h1>
        </div>
    </div>

    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="font-medium text-[#313647]">Edit place details</span>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('places.update', $place) }}">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Basic Information</h3>

                            <div class="mb-4">
                                <label for="identifier" class="block text-sm font-medium text-[#313647]">Identifier</label>
                                <input type="text" name="identifier" id="identifier" value="{{ $place->identifier }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                            </div>

                            <div class="mb-4">
                                <label for="label_en" class="block text-sm font-medium text-[#313647]">Label (English)</label>
                                <input type="text" name="label_en" id="label_en" value="{{ $place->label_en }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                            </div>

                            <div class="mb-4">
                                <label for="description_en" class="block text-sm font-medium text-[#313647]">Description (English)</label>
                                <textarea name="description_en" id="description_en" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">{{ $place->description_en }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="parent_id" class="block text-sm font-medium text-[#313647]">Parent Place (optional)</label>
                                <select name="parent_id" id="parent_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <option value="">— None (Top-Level) —</option>
                                    @foreach ($parentOptions->whereNull('parent_id') as $topLevel)
                                        <option value="{{ $topLevel->id }}" {{ $place->parent_id == $topLevel->id ? 'selected' : '' }}>
                                            {{ $topLevel->label_en }}
                                        </option>
                                        @foreach ($parentOptions->where('parent_id', $topLevel->id) as $child)
                                            <option value="{{ $child->id }}" {{ $place->parent_id == $child->id ? 'selected' : '' }}>
                                                &nbsp;&nbsp;&nbsp;└ {{ $child->label_en }}
                                            </option>
                                            @foreach ($parentOptions->where('parent_id', $child->id) as $grandchild)
                                                <option value="{{ $grandchild->id }}" {{ $place->parent_id == $grandchild->id ? 'selected' : '' }}>
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
                                    <input type="number" step="any" name="latitude" id="latitude" value="{{ $place->latitude }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                </div>
                                <div>
                                    <label for="longitude" class="block text-sm font-medium text-[#313647]">Longitude</label>
                                    <input type="number" step="any" name="longitude" id="longitude" value="{{ $place->longitude }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                </div>
                            </div>
                        </div>

                        <!-- Linked Open Data -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Linked Open Data</h3>

                            @include('partials.lod-field', [
                                'name' => 'tgn',
                                'label' => 'Getty TGN',
                                'value' => $place->tgn_id,
                                'mappingValue' => $place->tgn_mapping,
                                'mappingTypes' => $mappingTypes,
                                'urlPrefix' => 'http://vocab.getty.edu/tgn/',
                                'placeholder' => 'e.g. 7004474'
                            ])
                        </div>

                        <!-- Alternative Names -->
                        @include('partials.alternative-names', [
                            'alternativeNames' => $place->alternativeNames
                        ])

                        <div class="flex justify-between mt-6">
                            <div class="flex space-x-4">
                                <a href="{{ route('places.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-gray-400 text-gray-600 font-semibold rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="button" onclick="deletePlace()" class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4]">
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
        async function deletePlace() {
            if (!confirm('Are you sure you want to delete this place?')) return;
            try {
                const response = await fetch('{{ route('places.destroy', $place) }}', {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                if (response.ok) window.location.href = '{{ route('places.index') }}';
            } catch (error) {
                alert('Error deleting place');
            }
        }
    </script>
</x-app-layout>
