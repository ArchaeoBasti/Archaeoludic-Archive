<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    Edit: {{ $game->title }}
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
                <span class="font-medium">Edit game details, developers, literature, and vocabulary</span>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('games.update', $game->game_id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-[#313647]">Title</label>
                            <input type="text" name="title" id="title" value="{{ $game->title }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                        </div>

                        <div class="mb-4">
                            <label for="release_year" class="block text-sm font-medium text-[#313647]">Release Date</label>
                            <input type="date" name="release_year" id="release_year" value="{{ $game->release_year }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                        </div>

                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-[#313647] mb-4">Linked Open Data</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="igdb_id" class="block text-sm font-medium text-[#435663]">
                                        <img src="https://www.igdb.com/favicon.ico" width="16" class="inline mr-1"> IGDB ID
                                    </label>
                                    <div class="flex mt-1">
                                        <input type="number" name="igdb_id" id="igdb_id" value="{{ $game->igdb_id }}"
                                               class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <button type="button" onclick="searchIgdb()"
                                                class="bg-[#A3B087] text-[#313647] px-3 py-2 rounded-r-md hover:bg-[#FFF8D4] transition-colors flex items-center" title="Search IGDB">
                                            🔍
                                        </button>
                                    </div>
                                    <div id="igdb-results" class="mt-2 hidden border rounded-md bg-white shadow-lg max-h-60 overflow-y-auto"></div>
                                </div>

                                <div>
                                    <label for="steam_id" class="block text-sm font-medium text-[#435663]">
                                        <img src="https://store.steampowered.com/favicon.ico" width="16" class="inline mr-1"> Steam ID
                                    </label>
                                    <div class="flex mt-1">
                                        <input type="text" name="steam_id" id="steam_id" value="{{ $game->steam_id }}"
                                               class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <a href="https://store.steampowered.com/search/?term={{ urlencode($game->title) }}" target="_blank"
                                           class="bg-[#A3B087] text-[#313647] px-3 py-2 rounded-r-md hover:bg-[#FFF8D4] transition-colors flex items-center" title="Search Steam">
                                            🔍
                                        </a>
                                    </div>
                                </div>

                                <div>
                                    <label for="gog_id" class="block text-sm font-medium text-[#435663]">
                                        <img src="https://www.gog.com/favicon.ico" width="16" class="inline mr-1"> GOG ID
                                    </label>
                                    <div class="flex mt-1">
                                        <input type="text" name="gog_id" id="gog_id" value="{{ $game->gog_id }}"
                                               class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <a href="https://www.gog.com/en/games?query={{ urlencode($game->title) }}" target="_blank"
                                           class="bg-[#A3B087] text-[#313647] px-3 py-2 rounded-r-md hover:bg-[#FFF8D4] transition-colors flex items-center" title="Search GOG">
                                            🔍
                                        </a>
                                    </div>
                                </div>

                                <div>
                                    <label for="wikidata_id" class="block text-sm font-medium text-[#435663]">
                                        <img src="https://www.wikidata.org/favicon.ico" width="16" class="inline mr-1"> Wikidata ID
                                    </label>
                                    <div class="flex mt-1">
                                        <input type="text" name="wikidata_id" id="wikidata_id" value="{{ $game->wikidata_id }}"
                                               class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <button type="button" onclick="searchWikidata()"
                                                class="bg-[#A3B087] text-[#313647] px-3 py-2 rounded-r-md hover:bg-[#FFF8D4] transition-colors flex items-center" title="Search Wikidata">
                                            🔍
                                        </button>
                                    </div>
                                    <div id="wikidata-results" class="mt-2 hidden border rounded-md bg-white shadow-lg max-h-60 overflow-y-auto"></div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-6">

                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-[#313647] mb-4">Developer</h3>

                            <!-- Aktuelle Entwickler -->
                            <div class="mb-4" id="developer-list">
                                @forelse ($developers as $dev)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200" id="dev-row-{{ $dev->id }}">
                                        <div>
                                            <span class="font-medium text-[#313647]">{{ $dev->name }}</span>
                                            @if ($dev->website)
                                                <a href="{{ $dev->website }}" target="_blank" class="text-blue-600 text-sm ml-2">🔗</a>
                                            @endif
                                            @if ($dev->wikidata_id)
                                                <a href="https://www.wikidata.org/wiki/{{ $dev->wikidata_id }}" target="_blank" title="Wikidata" class="ml-1 hover:opacity-70">
                                                    <img src="https://www.wikidata.org/favicon.ico" width="14" class="inline">
                                                </a>
                                            @endif
                                        </div>
                                        <button type="button" onclick="removeDeveloper({{ $dev->id }})" class="text-red-600 hover:text-red-800">
                                            ✕
                                        </button>
                                    </div>
                                @empty
                                    <p class="text-gray-400" id="no-developers">No developer assigned</p>
                                @endforelse
                            </div>

                            <!-- Existierenden Entwickler hinzufügen -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-[#435663] mb-2">Add developer</label>
                                <div class="flex gap-2">
                                    <select id="developer_select" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <option value="">-- Select --</option>
                                        @foreach ($allDevelopers as $dev)
                                            <option value="{{ $dev->id }}">{{ $dev->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="addDeveloper()" class="px-4 py-2 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                        Add
                                    </button>
                                </div>
                            </div>

                            <!-- Neuen Entwickler anlegen -->
                            <div class="border-t border-gray-200 pt-4">
                                <label class="block text-sm font-medium text-[#435663] mb-2">Create new developer</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mb-2">
                                    <input type="text" id="new_dev_name" placeholder="Name" class="rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <input type="text" id="new_dev_website" placeholder="Website (optional)" class="rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <input type="text" id="new_dev_wikidata" placeholder="Wikidata ID (optional)" class="rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                </div>
                                <button type="button" onclick="createDeveloper()" class="px-4 py-2 bg-[#313647] text-white font-semibold rounded-lg hover:bg-[#435663] transition-colors">
                                    Create Developer
                                </button>
                                <span id="dev-create-status" class="ml-2 text-sm"></span>
                            </div>
                        </div>

                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-[#313647] mb-4">Literature</h3>

                            <!-- Aktuelle Literatur -->
                            <div class="mb-4" id="literature-list">
                                @forelse ($literature as $lit)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200" id="lit-row-{{ $lit->literature_id }}">
                                      <div>
                                          <span class="font-medium text-[#313647]">{{ $lit->authors ?? '' }} {{ $lit->year ? '(' . $lit->year . ')' : '' }} [{{ $lit->zotero_id }}]</span>
                                      </div>
                                        <button type="button" onclick="removeLiterature({{ $lit->literature_id }})" class="text-red-600 hover:text-red-800">
                                            ✕
                                        </button>
                                    </div>
                                @empty
                                    <p class="text-gray-400" id="no-literature">No literature assigned</p>
                                @endforelse
                            </div>

                            <!-- Literatur suchen und hinzufügen -->
                            <div>
                                <label class="block text-sm font-medium text-[#435663] mb-2">Add literature</label>
                                <div class="flex gap-2">
                                    <input type="text" id="zotero_search" placeholder="Search in Zotero..."
                                           class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                    <button type="button" onclick="searchZotero()" class="px-4 py-2 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                        Search
                                    </button>
                                </div>
                                <div id="zotero-results" class="mt-2 hidden border rounded-md bg-white shadow-lg max-h-60 overflow-y-auto"></div>
                            </div>
                        </div>

                        <!-- VOCABULARY SECTION -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-[#313647] mb-4">Vocabulary</h3>

                            <!-- Periods -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-[#435663] mb-2">Periods</h4>
                                <div class="mb-2" id="periods-list">
                                    @forelse ($periods as $period)
                                        <div class="inline-flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm mr-2 mb-2" id="period-row-{{ $period->id }}">
                                            <span>{{ $period->label_en }}</span>
                                            <button type="button" onclick="removePeriod({{ $period->id }})" class="ml-2 text-blue-600 hover:text-blue-800">✕</button>
                                        </div>
                                    @empty
                                        <p class="text-gray-400 text-sm" id="no-periods">No periods assigned</p>
                                    @endforelse
                                </div>
                                <div class="flex gap-2">
                                    <select id="period_select" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <option value="">-- Select Period --</option>
                                        @foreach ($allPeriods as $period)
                                            <option value="{{ $period->id }}">{{ $period->label_en }}</option>
                                            @foreach ($period->children as $child)
                                                <option value="{{ $child->id }}">&nbsp;&nbsp;&nbsp;└ {{ $child->label_en }}</option>
                                                @foreach ($child->children as $grandchild)
                                                    <option value="{{ $grandchild->id }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ {{ $grandchild->label_en }}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="addPeriod()" class="px-4 py-2 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                        Add
                                    </button>
                                </div>
                            </div>

                            <!-- Places -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-[#435663] mb-2">Places</h4>
                                <div class="mb-2" id="places-list">
                                    @forelse ($places as $place)
                                        <div class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm mr-2 mb-2" id="place-row-{{ $place->id }}">
                                            <span>{{ $place->label_en }}</span>
                                            <button type="button" onclick="removePlace({{ $place->id }})" class="ml-2 text-green-600 hover:text-green-800">✕</button>
                                        </div>
                                    @empty
                                        <p class="text-gray-400 text-sm" id="no-places">No places assigned</p>
                                    @endforelse
                                </div>
                                <div class="flex gap-2">
                                    <select id="place_select" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <option value="">-- Select Place --</option>
                                        @foreach ($allPlaces as $place)
                                            <option value="{{ $place->id }}">{{ $place->label_en }}</option>
                                            @foreach ($place->children as $child)
                                                <option value="{{ $child->id }}">&nbsp;&nbsp;&nbsp;└ {{ $child->label_en }}</option>
                                                @foreach ($child->children as $grandchild)
                                                    <option value="{{ $grandchild->id }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ {{ $grandchild->label_en }}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="addPlace()" class="px-4 py-2 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                        Add
                                    </button>
                                </div>
                            </div>

                            <!-- Gameplay Modes -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-[#435663] mb-2">Gameplay Modes</h4>
                                <div class="mb-2" id="gameplay-modes-list">
                                    @forelse ($gameplayModes as $mode)
                                        <div class="inline-flex items-center bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm mr-2 mb-2" id="mode-row-{{ $mode->id }}">
                                            <span>{{ $mode->label_en }}</span>
                                            <button type="button" onclick="removeGameplayMode({{ $mode->id }})" class="ml-2 text-purple-600 hover:text-purple-800">✕</button>
                                        </div>
                                    @empty
                                        <p class="text-gray-400 text-sm" id="no-gameplay-modes">No gameplay modes assigned</p>
                                    @endforelse
                                </div>
                                <div class="flex gap-2">
                                    <select id="gameplay_mode_select" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <option value="">-- Select Gameplay Mode --</option>
                                        @foreach ($allGameplayModes as $mode)
                                            <option value="{{ $mode->id }}">{{ $mode->label_en }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="addGameplayMode()" class="px-4 py-2 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                        Add
                                    </button>
                                </div>
                            </div>

                            <!-- Player Roles -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-[#435663] mb-2">Player Roles</h4>
                                <div class="mb-2" id="player-roles-list">
                                    @forelse ($playerRoles as $role)
                                        <div class="inline-flex items-center bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm mr-2 mb-2" id="role-row-{{ $role->id }}">
                                            <span>{{ $role->label_en }}</span>
                                            <button type="button" onclick="removePlayerRole({{ $role->id }})" class="ml-2 text-orange-600 hover:text-orange-800">✕</button>
                                        </div>
                                    @empty
                                        <p class="text-gray-400 text-sm" id="no-player-roles">No player roles assigned</p>
                                    @endforelse
                                </div>
                                <div class="flex gap-2">
                                    <select id="player_role_select" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <option value="">-- Select Player Role --</option>
                                        @foreach ($allPlayerRoles as $role)
                                            <option value="{{ $role->id }}">{{ $role->label_en }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="addPlayerRole()" class="px-4 py-2 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                        Add
                                    </button>
                                </div>
                            </div>

                            <!-- Tropes -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-[#435663] mb-2">Tropes</h4>
                                <div class="mb-2" id="current-tropes">
                                    @forelse ($tropes as $trope)
                                        <div class="inline-flex items-center bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm mr-2 mb-2" data-trope-id="{{ $trope->id }}">
                                            <span>{{ $trope->label_en }}</span>
                                            <button type="button" onclick="removeTrope({{ $trope->id }})" class="ml-2 text-purple-600 hover:text-purple-800">✕</button>
                                        </div>
                                    @empty
                                        <p class="text-gray-400 text-sm" id="no-tropes">No tropes assigned</p>
                                    @endforelse
                                </div>
                                <div class="flex gap-2">
                                    <select id="trope-select" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <option value="">-- Select Trope --</option>
                                        @foreach ($allTropes as $trope)
                                            <option value="{{ $trope->id }}">{{ $trope->label_en }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="addTrope()" class="px-4 py-2 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                        Add
                                    </button>
                                </div>
                            </div>

                            <!-- Historical Persons -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-[#435663] mb-2">Historical Persons</h4>
                                <div class="mb-2" id="current-persons">
                                    @forelse ($persons as $person)
                                        <div class="inline-flex items-center bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-sm mr-2 mb-2" data-person-id="{{ $person->id }}">
                                            <span>
                                                {{ $person->label_en }}
                                                @if ($person->birth_year || $person->death_year)
                                                    ({{ $person->birth_year < 0 ? abs($person->birth_year) . ' BCE' : $person->birth_year ?? '?' }} – {{ $person->death_year < 0 ? abs($person->death_year) . ' BCE' : $person->death_year ?? '?' }})
                                                @endif
                                            </span>
                                            <button type="button" onclick="removePerson({{ $person->id }})" class="ml-2 text-amber-600 hover:text-amber-800">✕</button>
                                        </div>
                                    @empty
                                        <p class="text-gray-400 text-sm" id="no-persons">No historical persons assigned</p>
                                    @endforelse
                                </div>
                                <div class="flex gap-2">
                                    <select id="person-select" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                                        <option value="">-- Select Person --</option>
                                        @foreach ($allPersons as $person)
                                            <option value="{{ $person->id }}">
                                                {{ $person->label_en }}
                                                @if ($person->birth_year || $person->death_year)
                                                    ({{ $person->birth_year < 0 ? abs($person->birth_year) . ' BCE' : $person->birth_year ?? '?' }} – {{ $person->death_year < 0 ? abs($person->death_year) . ' BCE' : $person->death_year ?? '?' }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="addPerson()" class="px-4 py-2 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between mt-6 sticky bottom-0 bg-white py-4 border-t border-gray-200">
                            <div class="flex space-x-4">
                                <a href="{{ route('games') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-400 text-gray-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="button" onclick="deleteGame()" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
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
        const gameId = {{ $game->game_id }};
        const csrfToken = '{{ csrf_token() }}';

        // IGDB Search
        async function searchIgdb() {
            const title = document.getElementById('title').value;
            const resultsDiv = document.getElementById('igdb-results');

            if (!title) {
                alert('Enter a title first');
                return;
            }

            resultsDiv.innerHTML = '<div class="p-2 text-gray-500">Searching...</div>';
            resultsDiv.classList.remove('hidden');

            try {
                const response = await fetch(`{{ route('igdb.search') }}?q=${encodeURIComponent(title)}`);
                const results = await response.json();

                if (results.length === 0) {
                    resultsDiv.innerHTML = '<div class="p-2 text-gray-500">No results found</div>';
                    return;
                }

                let html = '';
                results.forEach(game => {
                    html += `
                        <div class="p-2 hover:bg-gray-100 cursor-pointer border-b" onclick="selectIgdb(${game.id})">
                            <span class="font-medium">${game.name}</span>
                            <span class="text-gray-500 text-sm">(${game.year})</span>
                            <span class="text-gray-400 text-xs ml-2">ID: ${game.id}</span>
                        </div>
                    `;
                });
                resultsDiv.innerHTML = html;

            } catch (error) {
                resultsDiv.innerHTML = '<div class="p-2 text-red-500">Error during search</div>';
            }
        }

        function selectIgdb(id) {
            document.getElementById('igdb_id').value = id;
            document.getElementById('igdb-results').classList.add('hidden');
        }

        // Wikidata Search
        async function searchWikidata() {
            const title = document.getElementById('title').value;
            const resultsDiv = document.getElementById('wikidata-results');

            if (!title) {
                alert('Enter a title first');
                return;
            }

            resultsDiv.innerHTML = '<div class="p-2 text-gray-500">Searching...</div>';
            resultsDiv.classList.remove('hidden');

            try {
                const response = await fetch(`{{ route('wikidata.search') }}?q=${encodeURIComponent(title)}`);
                const results = await response.json();

                if (results.length === 0) {
                    resultsDiv.innerHTML = '<div class="p-2 text-gray-500">No results found</div>';
                    return;
                }

                let html = '';
                results.forEach(item => {
                    html += `
                        <div class="p-2 hover:bg-gray-100 cursor-pointer border-b" onclick="selectWikidata('${item.id}')">
                            <span class="font-medium">${item.name}</span>
                            <span class="text-gray-400 text-xs ml-2">${item.id}</span>
                            <div class="text-gray-500 text-sm">${item.description}</div>
                        </div>
                    `;
                });
                resultsDiv.innerHTML = html;

            } catch (error) {
                resultsDiv.innerHTML = '<div class="p-2 text-red-500">Error during search</div>';
            }
        }

        function selectWikidata(id) {
            document.getElementById('wikidata_id').value = id;
            document.getElementById('wikidata-results').classList.add('hidden');
        }

        // Developer functions
        async function addDeveloper() {
            const select = document.getElementById('developer_select');
            const devId = select.value;
            const devName = select.options[select.selectedIndex].text;

            if (!devId) {
                alert('Please select a developer');
                return;
            }

            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/developer`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ developer_id: devId })
                });

                if (response.ok) {
                    const list = document.getElementById('developer-list');
                    const noDev = document.getElementById('no-developers');
                    if (noDev) noDev.remove();

                    const newRow = document.createElement('div');
                    newRow.className = 'flex justify-between items-center py-2 border-b border-gray-200';
                    newRow.id = `dev-row-${devId}`;
                    newRow.innerHTML = `
                        <div><span class="font-medium text-[#313647]">${devName}</span></div>
                        <button type="button" onclick="removeDeveloper(${devId})" class="text-red-600 hover:text-red-800">✕</button>
                    `;
                    list.appendChild(newRow);
                    select.value = '';
                }
            } catch (error) {
                alert('Error adding developer');
            }
        }

        async function removeDeveloper(devId) {
            if (!confirm('Remove developer?')) return;

            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/developer/${devId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });

                if (response.ok) {
                    document.getElementById(`dev-row-${devId}`).remove();
                }
            } catch (error) {
                alert('Error removing developer');
            }
        }

        async function createDeveloper() {
            const name = document.getElementById('new_dev_name').value;
            const website = document.getElementById('new_dev_website').value;
            const wikidata = document.getElementById('new_dev_wikidata').value;
            const status = document.getElementById('dev-create-status');

            if (!name) {
                alert('Please enter a name');
                return;
            }

            try {
                const response = await fetch('{{ route('developer.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ name, website, wikidata_id: wikidata })
                });

                if (response.ok) {
                    const data = await response.json();
                    const select = document.getElementById('developer_select');
                    const option = document.createElement('option');
                    option.value = data.id;
                    option.text = data.name;
                    select.add(option);
                    select.value = data.id;

                    document.getElementById('new_dev_name').value = '';
                    document.getElementById('new_dev_website').value = '';
                    document.getElementById('new_dev_wikidata').value = '';

                    status.textContent = '✓ Created!';
                    status.className = 'ml-2 text-sm text-green-600';
                    setTimeout(() => { status.textContent = ''; }, 3000);
                }
            } catch (error) {
                status.textContent = 'Error';
                status.className = 'ml-2 text-sm text-red-600';
            }
        }

        // Zotero/Literature functions
        async function searchZotero() {
            const query = document.getElementById('zotero_search').value;
            const resultsDiv = document.getElementById('zotero-results');

            if (!query) {
                alert('Enter search term');
                return;
            }

            resultsDiv.innerHTML = '<div class="p-2 text-gray-500">Searching...</div>';
            resultsDiv.classList.remove('hidden');

            try {
                const response = await fetch(`{{ route('zotero.search') }}?q=${encodeURIComponent(query)}`);
                const results = await response.json();

                if (results.length === 0) {
                    resultsDiv.innerHTML = '<div class="p-2 text-gray-500">No results found</div>';
                    return;
                }

                let html = '';
                results.forEach(item => {
                    html += `
                        <div class="p-2 hover:bg-gray-100 cursor-pointer border-b" onclick="addLiterature('${item.key}', '${item.authors} (${item.year})')">
                            <span class="font-medium">${item.title}</span>
                            <div class="text-gray-500 text-sm">${item.authors} (${item.year})</div>
                            <span class="text-gray-400 text-xs">${item.key}</span>
                        </div>
                    `;
                });
                resultsDiv.innerHTML = html;

            } catch (error) {
                resultsDiv.innerHTML = '<div class="p-2 text-red-500">Error during search</div>';
            }
        }

        async function addLiterature(zoteroId, displayText) {
            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/literature`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ zotero_id: zoteroId })
                });

                if (response.ok) {
                    const list = document.getElementById('literature-list');
                    const noLit = document.getElementById('no-literature');
                    if (noLit) noLit.remove();

                    const newRow = document.createElement('div');
                    newRow.className = 'flex justify-between items-center py-2 border-b border-gray-200';
                    newRow.id = `lit-row-new-${zoteroId}`;
                    newRow.innerHTML = `
                        <div><span class="font-medium text-[#313647]">${zoteroId}</span> - ${displayText}</div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">✕</button>
                    `;
                    list.appendChild(newRow);

                    document.getElementById('zotero_search').value = '';
                    document.getElementById('zotero-results').classList.add('hidden');
                }
            } catch (error) {
                alert('Error during adding');
            }
        }

        async function removeLiterature(literatureId) {
            if (!confirm('Remove literature?')) return;

            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/literature/${literatureId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });

                if (response.ok) {
                    document.getElementById(`lit-row-${literatureId}`).remove();
                }
            } catch (error) {
                alert('Error during removal');
            }
        }

        // Period functions
        async function addPeriod() {
            const select = document.getElementById('period_select');
            const periodId = select.value;
            const label = select.options[select.selectedIndex].text.trim().replace('↳ ', '');

            if (!periodId) {
                alert('Please select a period');
                return;
            }

            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/periods`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ period_id: periodId })
                });

                if (response.ok) {
                    const list = document.getElementById('periods-list');
                    const noPeriods = document.getElementById('no-periods');
                    if (noPeriods) noPeriods.remove();

                    const newTag = document.createElement('div');
                    newTag.className = 'inline-flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm mr-2 mb-2';
                    newTag.id = `period-row-${periodId}`;
                    newTag.innerHTML = `<span>${label}</span><button type="button" onclick="removePeriod(${periodId})" class="ml-2 text-blue-600 hover:text-blue-800">✕</button>`;
                    list.appendChild(newTag);
                    select.value = '';
                }
            } catch (error) {
                alert('Error adding period');
            }
        }

        async function removePeriod(periodId) {
            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/periods/${periodId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });

                if (response.ok) {
                    document.getElementById(`period-row-${periodId}`).remove();
                }
            } catch (error) {
                alert('Error removing period');
            }
        }

        // Place functions
        async function addPlace() {
            const select = document.getElementById('place_select');
            const placeId = select.value;
            const label = select.options[select.selectedIndex].text.trim().replace('↳ ', '');

            if (!placeId) {
                alert('Please select a place');
                return;
            }

            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/places`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ place_id: placeId })
                });

                if (response.ok) {
                    const list = document.getElementById('places-list');
                    const noPlaces = document.getElementById('no-places');
                    if (noPlaces) noPlaces.remove();

                    const newTag = document.createElement('div');
                    newTag.className = 'inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm mr-2 mb-2';
                    newTag.id = `place-row-${placeId}`;
                    newTag.innerHTML = `<span>${label}</span><button type="button" onclick="removePlace(${placeId})" class="ml-2 text-green-600 hover:text-green-800">✕</button>`;
                    list.appendChild(newTag);
                    select.value = '';
                }
            } catch (error) {
                alert('Error adding place');
            }
        }

        async function removePlace(placeId) {
            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/places/${placeId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });

                if (response.ok) {
                    document.getElementById(`place-row-${placeId}`).remove();
                }
            } catch (error) {
                alert('Error removing place');
            }
        }

        // Gameplay Mode functions
        async function addGameplayMode() {
            const select = document.getElementById('gameplay_mode_select');
            const modeId = select.value;
            const label = select.options[select.selectedIndex].text;

            if (!modeId) {
                alert('Please select a gameplay mode');
                return;
            }

            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/gameplay-modes`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ gameplay_mode_id: modeId })
                });

                if (response.ok) {
                    const list = document.getElementById('gameplay-modes-list');
                    const noModes = document.getElementById('no-gameplay-modes');
                    if (noModes) noModes.remove();

                    const newTag = document.createElement('div');
                    newTag.className = 'inline-flex items-center bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm mr-2 mb-2';
                    newTag.id = `mode-row-${modeId}`;
                    newTag.innerHTML = `<span>${label}</span><button type="button" onclick="removeGameplayMode(${modeId})" class="ml-2 text-purple-600 hover:text-purple-800">✕</button>`;
                    list.appendChild(newTag);
                    select.value = '';
                }
            } catch (error) {
                alert('Error adding gameplay mode');
            }
        }

        async function removeGameplayMode(modeId) {
            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/gameplay-modes/${modeId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });

                if (response.ok) {
                    document.getElementById(`mode-row-${modeId}`).remove();
                }
            } catch (error) {
                alert('Error removing gameplay mode');
            }
        }

        // Player Role functions
        async function addPlayerRole() {
            const select = document.getElementById('player_role_select');
            const roleId = select.value;
            const label = select.options[select.selectedIndex].text;

            if (!roleId) {
                alert('Please select a player role');
                return;
            }

            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/player-roles`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ player_role_id: roleId })
                });

                if (response.ok) {
                    const list = document.getElementById('player-roles-list');
                    const noRoles = document.getElementById('no-player-roles');
                    if (noRoles) noRoles.remove();

                    const newTag = document.createElement('div');
                    newTag.className = 'inline-flex items-center bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm mr-2 mb-2';
                    newTag.id = `role-row-${roleId}`;
                    newTag.innerHTML = `<span>${label}</span><button type="button" onclick="removePlayerRole(${roleId})" class="ml-2 text-orange-600 hover:text-orange-800">✕</button>`;
                    list.appendChild(newTag);
                    select.value = '';
                }
            } catch (error) {
                alert('Error adding player role');
            }
        }

        async function removePlayerRole(roleId) {
            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}/player-roles/${roleId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });

                if (response.ok) {
                    document.getElementById(`role-row-${roleId}`).remove();
                }
            } catch (error) {
                alert('Error removing player role');
            }
        }

        // Delete Game
        async function deleteGame() {
            if (!confirm('Are you sure you want to delete this game? All links will be removed.')) {
                return;
            }

            try {
                const response = await fetch(`{{ url('/games') }}/${gameId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });

                if (response.ok || response.redirected) {
                    window.location.href = '{{ url('/games') }}';
                }
            } catch (error) {
                alert('Error deleting game');
            }
        }

        // Trope functions
        function addTrope() {
            const select = document.getElementById('trope-select');
            const tropeId = select.value;
            const tropeName = select.options[select.selectedIndex].text.replace(/^— /, '');

            if (!tropeId) return;

            fetch(`{{ url('/games') }}/{{ $game->game_id }}/trope`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ trope_id: tropeId })
            }).then(response => {
                if (response.ok) {
                    const container = document.getElementById('current-tropes');
                    const span = document.createElement('span');
                    span.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm bg-purple-100 text-purple-800';
                    span.dataset.tropeId = tropeId;
                    span.innerHTML = `${tropeName} <button type="button" onclick="removeTrope(${tropeId})" class="ml-2 text-purple-600 hover:text-purple-900">&times;</button>`;
                    container.appendChild(span);
                    select.value = '';
                }
            });
        }

        function removeTrope(tropeId) {
            fetch(`{{ url('/games') }}/{{ $game->game_id }}/trope/${tropeId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            }).then(response => {
                if (response.ok) {
                    const span = document.querySelector(`#current-tropes span[data-trope-id="${tropeId}"]`);
                    if (span) span.remove();
                }
            });
        }

        // Person functions
        function addPerson() {
            const select = document.getElementById('person-select');
            const personId = select.value;
            const personName = select.options[select.selectedIndex].text;

            if (!personId) return;

            fetch(`{{ url('/games') }}/{{ $game->game_id }}/person`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ person_id: personId })
            }).then(response => {
                if (response.ok) {
                    const container = document.getElementById('current-persons');
                    const span = document.createElement('span');
                    span.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm bg-amber-100 text-amber-800';
                    span.dataset.personId = personId;
                    span.innerHTML = `${personName} <button type="button" onclick="removePerson(${personId})" class="ml-2 text-amber-600 hover:text-amber-900">&times;</button>`;
                    container.appendChild(span);
                    select.value = '';
                }
            });
        }

        function removePerson(personId) {
            fetch(`{{ url('/games') }}/{{ $game->game_id }}/person/${personId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            }).then(response => {
                if (response.ok) {
                    const span = document.querySelector(`#current-persons span[data-person-id="${personId}"]`);
                    if (span) span.remove();
                }
            });
        }
    </script>
</x-app-layout>
