<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    Edit: {{ $playerRole->label_en }}
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
                <span class="font-medium">Edit player role details</span>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('player-roles.update', $playerRole) }}">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Basic Information</h3>

                            <div class="mb-4">
                                <label for="identifier" class="block text-sm font-medium text-[#313647]">Identifier</label>
                                <input type="text" name="identifier" id="identifier" value="{{ $playerRole->identifier }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                            </div>

                            <div class="mb-4">
                                <label for="label_en" class="block text-sm font-medium text-[#313647]">Label (English)</label>
                                <input type="text" name="label_en" id="label_en" value="{{ $playerRole->label_en }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                            </div>

                            <div class="mb-4">
                                <label for="description_en" class="block text-sm font-medium text-[#313647]">Description (English)</label>
                                <textarea name="description_en" id="description_en" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">{{ $playerRole->description_en }}</textarea>
                            </div>
                        </div>

                        <!-- Alternative Names -->
                        @include('partials.alternative-names', [
                            'alternativeNames' => $playerRole->alternativeNames
                        ])

                        <div class="flex justify-between mt-6">
                            <div class="flex space-x-4">
                                <a href="{{ route('player-roles.index') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-400 text-gray-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="button" onclick="deleteRole()" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
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
        async function deleteRole() {
            if (!confirm('Are you sure you want to delete this player role? Links to games will also be removed.')) {
                return;
            }

            try {
                const response = await fetch('{{ route('player-roles.destroy', $playerRole) }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (response.ok) {
                    window.location.href = '{{ route('player-roles.index') }}';
                }
            } catch (error) {
                alert('Error deleting player role');
            }
        }
    </script>
</x-app-layout>
