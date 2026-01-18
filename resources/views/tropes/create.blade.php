<x-app-layout>
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">New Trope</h1>
            </div>
        </div>
    </div>

    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-[#313647]">
                <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="font-medium">Add a new trope to the vocabulary</span>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('tropes.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="identifier" class="block text-sm font-medium text-[#313647]">Identifier</label>
                            <input type="text" name="identifier" id="identifier" required placeholder="e.g. adventurer-archaeologist"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                            <p class="text-sm text-[#435663] mt-1">Use lowercase with hyphens</p>
                        </div>

                        <div class="mb-4">
                            <label for="label_en" class="block text-sm font-medium text-[#313647]">Label (English)</label>
                            <input type="text" name="label_en" id="label_en" required placeholder="e.g. Adventurer Archaeologist"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                        </div>

                        <div class="mb-4">
                            <label for="description_en" class="block text-sm font-medium text-[#313647]">Description (English)</label>
                            <textarea name="description_en" id="description_en" rows="4"
                                      placeholder="Describe the trope and its typical manifestations..."
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="tvtropes_url" class="block text-sm font-medium text-[#313647]">TV Tropes URL (optional)</label>
                            <input type="url" name="tvtropes_url" id="tvtropes_url" placeholder="https://tvtropes.org/pmwiki/pmwiki.php/Main/..."
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                        </div>

                        <div class="mb-4">
                            <label for="wikidata_id" class="block text-sm font-medium text-[#313647]">Wikidata ID (optional)</label>
                            <input type="text" name="wikidata_id" id="wikidata_id" placeholder="e.g. Q12345"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                        </div>

                        <div class="flex justify-between mt-6">
                            <a href="{{ route('tropes.index') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-400 text-gray-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
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
</x-app-layout>
