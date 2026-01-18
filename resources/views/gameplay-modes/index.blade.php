<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    Gameplay Modes
                </h1>
                @auth
                    <a href="{{ route('gameplay-modes.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Mode
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ $gameplayModes->count() }} Modes</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="space-y-4">
                        @foreach ($gameplayModes as $mode)
                            <div class="flex justify-between items-start p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div>
                                    <span class="text-xs text-gray-400">{{ $mode->identifier }}</span>
                                    <h4 class="font-medium text-[#313647]">
                                        <a href="{{ route('gameplay-modes.show', $mode) }}" class="hover:text-[#435663] transition-colors">
                                            {{ $mode->label_en }}
                                        </a>
                                    </h4>
                                    @if ($mode->description_en)
                                        <p class="text-[#435663] text-sm mt-1">{{ Str::limit($mode->description_en, 200) }}</p>
                                    @endif
                                </div>
                                @auth
                                    <a href="{{ route('gameplay-modes.edit', $mode) }}" class="text-blue-600 hover:underline ml-4">
                                        Edit
                                    </a>
                                @endauth
                            </div>
                        @endforeach
                    </div>

                    @if ($gameplayModes->isEmpty())
                        <p class="text-gray-400">No gameplay modes defined yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
