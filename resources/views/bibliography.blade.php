<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    Bibliography
                </h1>
            </div>
        </div>
    </div>

    <!-- Gelber Streifen -->
    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-6 text-[#313647]">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                    <span class="font-medium">Curated scholarly literature on archaeogaming</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">

                    <p class="text-[#435663] mb-8">
                        A curated collection of scholarly literature on archaeogaming and related topics.
                        All references are managed through our public
                        <a href="https://www.zotero.org/groups/6296607/archaeogaming/library"
                           target="_blank"
                           class="text-blue-600 hover:underline">Zotero library</a>.
                    </p>

                    @foreach ($bibliography as $category => $items)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">{{ $category }}</h3>
                            @if (count($items) > 0)
                                <ul class="list-disc list-outside ml-6 space-y-2">
                                    @foreach ($items as $item)
                                        <li class="text-[#435663] leading-relaxed">{!! $item['citation'] !!}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-400">No entries in this category yet.</p>
                            @endif
                        </div>
                    @endforeach

                    @if (empty($bibliography))
                        <p class="text-gray-400">No bibliography entries yet.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
