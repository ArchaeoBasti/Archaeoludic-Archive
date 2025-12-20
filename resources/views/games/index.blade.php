<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    List of Archaeogames
                </h1>
                <div class="flex space-x-4 items-center">
                    @auth
                        <a href="{{ route('games.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            New Game
                        </a>
                    @endauth
                    <button id="gridView" class="p-2 rounded hover:bg-[#435663] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#FFF8D4]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                    </button>
                    <button id="tableView" class="p-2 rounded hover:bg-[#435663] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#A3B087]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Gelber Streifen mit Statistik und Sortierung -->
    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-between items-center gap-4">
                <div class="flex items-center gap-2 text-[#313647]">
                    <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ $gameCount }} Games</span>
                </div>

                <!-- Sortierung für Kachelansicht -->
                <div id="gridSort" class="{{ request()->get('view', 'grid') === 'table' ? 'hidden' : '' }} flex items-center gap-2">
                    <span class="text-sm text-[#435663]">Sort by:</span>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => ($sort === 'title' && $direction === 'asc') ? 'desc' : 'asc', 'view' => 'grid']) }}"
                       class="px-3 py-1 rounded text-sm {{ $sort === 'title' ? 'bg-[#313647] text-white' : 'bg-white text-[#313647] hover:bg-gray-100' }} transition-colors">
                        Title
                        @if($sort === 'title')
                            <span class="ml-1">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'release_year', 'direction' => ($sort === 'release_year' && $direction === 'asc') ? 'desc' : 'asc', 'view' => 'grid']) }}"
                       class="px-3 py-1 rounded text-sm {{ $sort === 'release_year' ? 'bg-[#313647] text-white' : 'bg-white text-[#313647] hover:bg-gray-100' }} transition-colors">
                        Year
                        @if($sort === 'release_year')
                            <span class="ml-1">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </a>
                </div>

                <!-- Sortierung für Tabellenansicht (mit Developer) -->
                <div id="tableSort" class="{{ request()->get('view', 'grid') === 'table' ? '' : 'hidden' }} flex items-center gap-2">
                    <span class="text-sm text-[#435663]">Sort by:</span>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => ($sort === 'title' && $direction === 'asc') ? 'desc' : 'asc', 'view' => 'table']) }}"
                       class="px-3 py-1 rounded text-sm {{ $sort === 'title' ? 'bg-[#313647] text-white' : 'bg-white text-[#313647] hover:bg-gray-100' }} transition-colors">
                        Title
                        @if($sort === 'title')
                            <span class="ml-1">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'release_year', 'direction' => ($sort === 'release_year' && $direction === 'asc') ? 'desc' : 'asc', 'view' => 'table']) }}"
                       class="px-3 py-1 rounded text-sm {{ $sort === 'release_year' ? 'bg-[#313647] text-white' : 'bg-white text-[#313647] hover:bg-gray-100' }} transition-colors">
                        Year
                        @if($sort === 'release_year')
                            <span class="ml-1">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'developer', 'direction' => ($sort === 'developer' && $direction === 'asc') ? 'desc' : 'asc', 'view' => 'table']) }}"
                       class="px-3 py-1 rounded text-sm {{ $sort === 'developer' ? 'bg-[#313647] text-white' : 'bg-white text-[#313647] hover:bg-gray-100' }} transition-colors">
                        Developer
                        @if($sort === 'developer')
                            <span class="ml-1">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">

                    <!-- Kachelansicht -->
                    <div id="gridContainer" class="{{ request()->get('view', 'grid') === 'table' ? 'hidden' : '' }} flex flex-wrap gap-6 justify-start">
                        @foreach ($games as $game)
                            <a href="{{ route('games.show', $game->game_id) }}" class="border border-gray-200 rounded-lg p-2 hover:shadow-lg transition-shadow w-[200px] block bg-white">
                                @if ($game->igdb && $game->igdb->cover_url)
                                    <img src="{{ $game->igdb->cover_url }}" alt="{{ $game->title }}" class="w-full rounded">
                                @else
                                    <div class="w-full h-40 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-500 text-sm text-center px-2">{{ $game->title }}</span>
                                    </div>
                                @endif
                                <h3 class="mt-2 text-sm font-semibold text-[#313647] truncate" title="{{ $game->title }}">{{ $game->title }}</h3>
                                <div class="flex justify-between items-center text-xs text-[#435663]">
                                    <span>{{ substr($game->release_year, 0, 4) }}</span>
                                    <div class="flex space-x-2">
                                        <span title="Literature References" class="flex items-center text-amber-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-0.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                            </svg>
                                            {{ $game->literature_count }}
                                        </span>
                                        &nbsp;
                                        <span title="Linked Open Data" class="flex items-center text-blue-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-0.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                            </svg>
                                            {{ $game->lod_count }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Tabellenansicht -->
                    <div id="tableContainer" class="{{ request()->get('view', 'grid') === 'table' ? '' : 'hidden' }}">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left p-2 text-[#313647]">Title</th>
                                    <th class="text-left p-2 text-[#313647]">Year</th>
                                    <th class="text-left p-2 text-[#313647]">Developer</th>
                                    <th class="text-left p-2 text-[#313647]">Literature</th>
                                    <th class="text-center p-2 text-[#313647]" colspan="4">LOD</th>
                                    @auth
                                        <th class="text-center p-2 text-[#313647]">Action</th>
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($games as $game)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="p-2">
                                            <a href="{{ route('games.show', $game->game_id) }}" class="text-blue-600 hover:underline">{{ $game->title }}</a>
                                        </td>
                                        <td class="p-2 text-[#435663]">{{ substr($game->release_year, 0, 4) }}</td>
                                        <td class="p-2 text-[#435663]">
                                            @if (!empty($game->developers))
                                                @foreach (explode(',', $game->developers) as $index => $dev)
                                                    @php
                                                        [$name, $website] = array_pad(explode('|', trim($dev)), 2, null);
                                                    @endphp
                                                    @if ($index > 0), @endif
                                                    @if ($website)
                                                        <a href="{{ $website }}" target="_blank" class="text-blue-600 hover:underline">{{ $name }}</a>
                                                    @else
                                                        {{ $name }}
                                                    @endif
                                                @endforeach
                                            @else
                                                –
                                            @endif
                                        </td>
                                        <td class="p-2 text-[#435663]">
                                            @if (count($game->citations) > 0)
                                                @foreach ($game->citations as $index => $cite)
                                                    @if ($index > 0); @endif
                                                    <a href="{{ $cite['url'] }}" target="_blank" class="text-blue-600 hover:underline">{{ $cite['citation'] }}</a>
                                                @endforeach
                                            @else
                                                –
                                            @endif
                                        </td>
                                        <td class="p-2 text-center">
                                            @if ($game->steam_id)
                                                <a href="https://store.steampowered.com/app/{{ $game->steam_id }}/" target="_blank" class="hover:opacity-70 transition-opacity">
                                                    <img src="https://store.steampowered.com/favicon.ico" width="20" class="inline">
                                                </a>
                                            @else
                                                –
                                            @endif
                                        </td>
                                        <td class="p-2 text-center">
                                            @if ($game->gog_id)
                                                <a href="https://www.gog.com/{{ $game->gog_id }}/" target="_blank" class="hover:opacity-70 transition-opacity">
                                                    <img src="https://www.gog.com/favicon.ico" width="20" class="inline">
                                                </a>
                                            @else
                                                –
                                            @endif
                                        </td>
                                        <td class="p-2 text-center">
                                            @if ($game->wikidata_id)
                                                <a href="https://www.wikidata.org/wiki/{{ $game->wikidata_id }}" target="_blank" class="hover:opacity-70 transition-opacity">
                                                    <img src="https://www.wikidata.org/favicon.ico" width="20" class="inline">
                                                </a>
                                            @else
                                                –
                                            @endif
                                        </td>
                                        <td class="p-2 text-center">
                                            @if ($game->igdb && $game->igdb->slug)
                                                <a href="{{ $game->igdb->slug }}" target="_blank" class="hover:opacity-70 transition-opacity">
                                                    <img src="https://www.igdb.com/favicon.ico" width="20" class="inline">
                                                </a>
                                            @else
                                                –
                                            @endif
                                        </td>
                                        @auth
                                            <td class="p-2 text-center">
                                                <a href="{{ route('games.edit', $game->game_id) }}" class="text-blue-600 hover:underline">
                                                    Edit
                                                </a>
                                            </td>
                                        @endauth
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $games->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        const gridBtn = document.getElementById('gridView');
        const tableBtn = document.getElementById('tableView');
        const gridContainer = document.getElementById('gridContainer');
        const tableContainer = document.getElementById('tableContainer');
        const gridIcon = gridBtn.querySelector('svg');
        const tableIcon = tableBtn.querySelector('svg');
        const gridSort = document.getElementById('gridSort');
        const tableSort = document.getElementById('tableSort');

        // Aktuelle Ansicht aus URL lesen
        const urlParams = new URLSearchParams(window.location.search);
        const currentView = urlParams.get('view') || 'grid';

        function updateUrl(view) {
            urlParams.set('view', view);
            const newUrl = window.location.pathname + '?' + urlParams.toString();
            window.history.replaceState({}, '', newUrl);
        }

        gridBtn.addEventListener('click', function() {
            if (gridBtn.disabled) return;
            gridContainer.classList.remove('hidden');
            tableContainer.classList.add('hidden');
            gridSort.classList.remove('hidden');
            tableSort.classList.add('hidden');
            gridIcon.classList.remove('text-[#A3B087]');
            gridIcon.classList.add('text-[#FFF8D4]');
            tableIcon.classList.remove('text-[#FFF8D4]');
            tableIcon.classList.add('text-[#A3B087]');
            gridBtn.disabled = true;
            tableBtn.disabled = false;
            gridBtn.classList.add('cursor-default');
            gridBtn.classList.remove('hover:bg-[#435663]');
            tableBtn.classList.remove('cursor-default');
            tableBtn.classList.add('hover:bg-[#435663]');
            updateUrl('grid');
        });

        tableBtn.addEventListener('click', function() {
            if (tableBtn.disabled) return;
            tableContainer.classList.remove('hidden');
            gridContainer.classList.add('hidden');
            tableSort.classList.remove('hidden');
            gridSort.classList.add('hidden');
            tableIcon.classList.remove('text-[#A3B087]');
            tableIcon.classList.add('text-[#FFF8D4]');
            gridIcon.classList.remove('text-[#FFF8D4]');
            gridIcon.classList.add('text-[#A3B087]');
            tableBtn.disabled = true;
            gridBtn.disabled = false;
            tableBtn.classList.add('cursor-default');
            tableBtn.classList.remove('hover:bg-[#435663]');
            gridBtn.classList.remove('cursor-default');
            gridBtn.classList.add('hover:bg-[#435663]');
            updateUrl('table');
        });

        // Initialer Zustand basierend auf URL-Parameter
        if (currentView === 'table') {
            tableBtn.disabled = true;
            tableBtn.classList.add('cursor-default');
            tableBtn.classList.remove('hover:bg-[#435663]');
            gridBtn.disabled = false;
            gridBtn.classList.remove('cursor-default');
            gridBtn.classList.add('hover:bg-[#435663]');
            tableIcon.classList.remove('text-[#A3B087]');
            tableIcon.classList.add('text-[#FFF8D4]');
            gridIcon.classList.remove('text-[#FFF8D4]');
            gridIcon.classList.add('text-[#A3B087]');
        } else {
            gridBtn.disabled = true;
            gridBtn.classList.add('cursor-default');
            gridBtn.classList.remove('hover:bg-[#435663]');
            tableBtn.disabled = false;
            tableBtn.classList.remove('cursor-default');
            tableBtn.classList.add('hover:bg-[#435663]');
        }
    </script>
</x-app-layout>
