<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    Vocabulary
                </h1>
                @auth
                    <a href="{{ route('vocabulary.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Entry
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Gelber Streifen mit Statistik -->
    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-6 text-[#313647]">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span class="font-medium">{{ $vocabularies->count() }} Terms</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span class="font-medium">{{ $categories->count() }} Categories</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    @foreach ($categories as $category => $items)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">{{ $category ?: 'Uncategorized' }}</h3>
                            <div class="space-y-4">
                                @foreach ($items as $vocab)
                                    <div class="flex justify-between items-start p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <div>
                                            <span class="text-xs text-gray-400">{{ $vocab->voc_id }}</span>
                                            <h4 class="font-medium text-[#313647]">{{ $vocab->term }}</h4>
                                            @if ($vocab->description)
                                                <p class="text-[#435663] text-sm mt-1">{{ $vocab->description }}</p>
                                            @endif
                                        </div>
                                        @auth
                                            <a href="{{ route('vocabulary.edit', $vocab->voc_id) }}" class="text-blue-600 hover:underline">
                                                Edit
                                            </a>
                                        @endauth
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    @if ($vocabularies->isEmpty())
                        <p class="text-gray-400">No vocabulary entries yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
