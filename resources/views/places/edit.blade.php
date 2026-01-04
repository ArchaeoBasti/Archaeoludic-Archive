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
                                    <option value="{{ $topLevel->id }}" {{ (isset($place) && $place->parent_id == $topLevel->id) ? 'selected' : '' }}>
                                        {{ $topLevel->label_en }}
                                    </option>
                                    @foreach ($parentOptions->where('parent_id', $topLevel->id) as $child)
                                        <option value="{{ $child->id }}" {{ (isset($place) && $place->parent_id == $child->id) ? 'selected' : '' }}>
                                            &nbsp;&nbsp;&nbsp;└ {{ $child->label_en }}
                                        </option>
                                        @foreach ($parentOptions->where('parent_id', $child->id) as $grandchild)
                                            <option value="{{ $grandchild->id }}" {{ (isset($place) && $place->parent_id == $grandchild->id) ? 'selected' : '' }}>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ {{ $grandchild->label_en }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
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

                        <div>
                            <label for="tgn_id" class="block text-sm font-medium text-gray-700">Getty TGN ID</label>
                            <input type="text" name="tgn_id" id="tgn_id" value="{{ old('tgn_id', $place->tgn_id ?? '') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#435663] focus:ring-[#435663]"
                                   placeholder="z.B. 7004474">
                            <p class="mt-1 text-sm text-gray-500">
                                ID aus dem <a href="https://www.getty.edu/research/tools/vocabularies/tgn/" target="_blank" class="text-[#435663] hover:underline">Getty Thesaurus of Geographic Names</a>
                            </p>
                        </div>

                        <div class="flex justify-between mt-6">
                            <div class="flex space-x-4">
                                <a href="{{ route('places.index') }}" class="px-6 py-3 border-2 border-gray-400 text-gray-600 font-semibold rounded-lg hover:bg-gray-100">
                                    ← Cancel
                                </a>
                                <button type="button" onclick="deletePlace()" class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">
                                    Delete
                                </button>
                            </div>
                            <button type="submit" class="px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4]">
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
