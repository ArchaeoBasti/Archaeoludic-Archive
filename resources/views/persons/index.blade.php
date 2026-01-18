<x-app-layout>
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">Historical Persons</h1>
                @auth
                    <a href="{{ route('persons.create') }}" class="inline-flex items-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Person
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-6 text-[#313647]">
                <span class="font-medium">{{ $persons->count() }} Persons</span>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    @if ($persons->count() > 0)
                        <div class="space-y-4">
                            @foreach ($persons as $person)
                                <div class="flex justify-between items-start p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex-1">
                                        <span class="text-xs text-gray-400">{{ $person->identifier }}</span>
                                        <h4 class="font-medium text-[#313647]">
                                            <a href="{{ route('persons.show', $person) }}" class="hover:text-[#435663] transition-colors">
                                                {{ $person->label_en }}
                                            </a>
                                        </h4>
                                        @if ($person->lifespan)
                                            <p class="text-sm text-[#435663]">{{ $person->lifespan }}</p>
                                        @endif
                                        @if ($person->description_en)
                                            <p class="text-[#435663] text-sm mt-1">{{ Str::limit($person->description_en, 200) }}</p>
                                        @endif
                                        <div class="flex gap-4 mt-2">
                                            @if ($person->gnd_id)
                                                <a href="https://d-nb.info/gnd/{{ $person->gnd_id }}" target="_blank" class="text-xs text-blue-600 hover:underline">GND</a>
                                            @endif
                                            @if ($person->wikidata_id)
                                                <a href="https://www.wikidata.org/wiki/{{ $person->wikidata_id }}" target="_blank" class="text-xs text-blue-600 hover:underline">Wikidata</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="text-sm text-gray-500">{{ $person->games->count() }} games</span>
                                        @auth
                                            <a href="{{ route('persons.edit', $person) }}" class="text-blue-600 hover:underline">Edit</a>
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400">No persons defined yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
