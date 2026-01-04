<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    New Period
                </h1>
            </div>
        </div>
    </div>

    <!-- Gelber Streifen -->
    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-[#313647]">
                <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="font-medium">Add a new historical period to the vocabulary</span>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('periods.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="identifier" class="block text-sm font-medium text-[#313647]">Identifier</label>
                            <input type="text" name="identifier" id="identifier" required placeholder="e.g. stone-age"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                            <p class="text-sm text-[#435663] mt-1">Use lowercase with hyphens (e.g. "bronze-age", "ancient-rome")</p>
                        </div>

                        <div class="mb-4">
                            <label for="label_en" class="block text-sm font-medium text-[#313647]">Label (English)</label>
                            <input type="text" name="label_en" id="label_en" required placeholder="e.g. Stone Age"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                        </div>

                        <div class="mb-4">
                            <label for="description_en" class="block text-sm font-medium text-[#313647]">Description (English)</label>
                            <textarea name="description_en" id="description_en" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="parent_id" class="block text-sm font-medium text-[#313647]">Parent Period (optional)</label>
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

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="start_year" class="block text-sm font-medium text-[#313647]">Start Year</label>
                                <input type="number" name="start_year" id="start_year" placeholder="e.g. -3000"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                <p class="text-sm text-[#435663] mt-1">Use negative numbers for BCE</p>
                            </div>
                            <div>
                                <label for="end_year" class="block text-sm font-medium text-[#313647]">End Year</label>
                                <input type="number" name="end_year" id="end_year" placeholder="e.g. -1200"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                <p class="text-sm text-[#435663] mt-1">Use negative numbers for BCE</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="start_uncertain" id="start_uncertain" value="1"
                                       class="rounded border-gray-300 text-[#A3B087] focus:ring-[#A3B087]">
                                <label for="start_uncertain" class="ml-2 text-sm text-[#313647]">Start date uncertain</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="end_uncertain" id="end_uncertain" value="1"
                                       class="rounded border-gray-300 text-[#A3B087] focus:ring-[#A3B087]">
                                <label for="end_uncertain" class="ml-2 text-sm text-[#313647]">End date uncertain</label>
                            </div>
                        </div>

                        <div class="flex justify-between mt-6">
                            <a href="{{ route('periods.index') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-400 text-gray-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
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
