<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\ZoteroService;
use App\Models\ZoteroCache;
use App\Services\IgdbService;
use Illuminate\Support\Facades\Http;
use App\Models\Period;
use App\Models\Place;
use App\Models\GameplayMode;
use App\Models\PlayerRole;
use App\Models\Trope;
use App\Models\Person;

class GameController extends Controller
{
    public function index(Request $request, ZoteroService $zoteroService, IgdbService $igdbService)
    {
        // Sortierung
        $sort = $request->get('sort', 'title');
        $direction = $request->get('direction', 'asc');

        // Erlaubte Sortierfelder
        $allowedSorts = ['title', 'release_year', 'developer'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'title';
        }

        // Gesamtanzahl für Statistik
        $gameCount = DB::table('1_games')->count();

        // Query aufbauen
        $query = DB::table('1_games')
            ->leftJoin('1_game_developer', '1_games.game_id', '=', '1_game_developer.game_id')
            ->leftJoin('1_developer', '1_game_developer.developer_id', '=', '1_developer.id')
            ->leftJoin('1_literature', '1_games.game_id', '=', '1_literature.game_id')
            ->select(
                '1_games.game_id',
                '1_games.title',
                '1_games.release_year',
                '1_games.steam_id',
                '1_games.gog_id',
                '1_games.wikidata_id',
                '1_games.igdb_id',
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT_WS("|", 1_developer.name, 1_developer.website) SEPARATOR ",") AS developers'),
                DB::raw('GROUP_CONCAT(DISTINCT 1_literature.zotero_id SEPARATOR ", ") AS zotero_ids'),
                DB::raw('MIN(1_developer.name) AS developer_name')
            )
            ->groupBy('1_games.game_id', '1_games.title', '1_games.release_year', '1_games.steam_id', '1_games.gog_id', '1_games.wikidata_id', '1_games.igdb_id');

        // Sortierung anwenden
        if ($sort === 'developer') {
            $query->orderBy('developer_name', $direction);
        } elseif ($sort === 'release_year') {
            $query->orderBy('1_games.release_year', $direction);
        } else {
            $query->orderBy('1_games.title', $direction);
        }

        // Pagination
        $games = $query->paginate(30)->withQueryString();

        // IGDB und Zitate nur für die aktuelle Seite laden
        foreach ($games as $game) {
            $game->citations = $this->buildCitations($game->zotero_ids, $zoteroService);
            if ($game->igdb_id) {
                $game->igdb = $igdbService->getGameById($game->igdb_id);
            } else {
                $game->igdb = $igdbService->getGameData($game->title);
            }
            $game->literature_count = count($game->citations);
            $lod_count = 0;
            if (!empty($game->steam_id)) $lod_count++;
            if (!empty($game->gog_id)) $lod_count++;
            if (!empty($game->wikidata_id)) $lod_count++;
            if ($game->igdb && $game->igdb->slug) $lod_count++;
            $game->lod_count = $lod_count;
        }

        return view('games.index', compact('games', 'gameCount', 'sort', 'direction'));
    }

    public function update(Request $request, $id)
    {
        DB::table('1_games')
            ->where('game_id', $id)
            ->update([
                'title' => $request->input('title'),
                'release_year' => $request->input('release_year'),
                'steam_id' => $request->input('steam_id'),
                'gog_id' => $request->input('gog_id'),
                'wikidata_id' => $request->input('wikidata_id'),
                'igdb_id' => $request->input('igdb_id'),
                'updated_at' => now(),
            ]);

        return redirect()->route('games.show', $id);
    }

    public function igdbSearch(Request $request, IgdbService $igdbService)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return response()->json([]);
        }

        $results = $igdbService->searchGames($query, 10);

        return response()->json($results);
    }

    public function wikidataSearch(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return response()->json([]);
        }

        $response = Http::withHeaders([
            'User-Agent' => 'ArchaeogamingDB/1.0 (educational project)'
        ])->get('https://www.wikidata.org/w/api.php', [
            'action' => 'wbsearchentities',
            'search' => $query,
            'language' => 'en',
            'type' => 'item',
            'format' => 'json',
            'limit' => 10,
        ]);

        if ($response->failed()) {
            return response()->json([]);
        }

        $results = collect($response->json()['search'] ?? [])->map(function ($item) {
            return [
                'id' => $item['id'],
                'name' => $item['label'] ?? 'Unbekannt',
                'description' => $item['description'] ?? '',
            ];
        });

        return response()->json($results);
    }

    public function addDeveloper(Request $request, $id)
    {
        $developerId = $request->input('developer_id');

        $exists = DB::table('1_game_developer')
            ->where('game_id', $id)
            ->where('developer_id', $developerId)
            ->exists();

        if (!$exists) {
            DB::table('1_game_developer')->insert([
                'game_id' => $id,
                'developer_id' => $developerId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function removeDeveloper($id, $developerId)
    {
        DB::table('1_game_developer')
            ->where('game_id', $id)
            ->where('developer_id', $developerId)
            ->delete();

        return response()->json(['success' => true]);
    }

    public function createDeveloper(Request $request)
    {
        $id = DB::table('1_developer')->insertGetId([
            'name' => $request->input('name'),
            'website' => $request->input('website'),
            'wikidata_id' => $request->input('wikidata_id'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['id' => $id, 'name' => $request->input('name')]);
    }

    public function zoteroSearch(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return response()->json([]);
        }

        $groupId = config('services.zotero.group_id');

        $response = Http::get("https://api.zotero.org/groups/{$groupId}/items", [
            'q' => $query,
            'limit' => 10,
            'format' => 'json',
        ]);

        if ($response->failed()) {
            return response()->json([]);
        }

        $results = collect($response->json())->map(function ($item) {
            $data = $item['data'] ?? [];
            $creators = collect($data['creators'] ?? [])
                ->filter(fn($c) => ($c['creatorType'] ?? '') === 'author')
                ->map(fn($c) => $c['lastName'] ?? $c['name'] ?? '')
                ->join(', ');

            $year = '';
            if (!empty($data['date'])) {
                preg_match('/\d{4}/', $data['date'], $matches);
                $year = $matches[0] ?? '';
            }

            return [
                'key' => $item['key'],
                'title' => $data['title'] ?? 'Ohne Titel',
                'authors' => $creators ?: 'Unbekannt',
                'year' => $year,
            ];
        });

        return response()->json($results);
    }

    public function addLiterature(Request $request, $id)
    {
        $zoteroId = $request->input('zotero_id');

        $exists = DB::table('1_literature')
            ->where('game_id', $id)
            ->where('zotero_id', $zoteroId)
            ->exists();

        if (!$exists) {
            DB::table('1_literature')->insert([
                'game_id' => $id,
                'zotero_id' => $zoteroId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function removeLiterature($id, $literatureId)
    {
        DB::table('1_literature')
            ->where('literature_id', $literatureId)
            ->delete();

        return response()->json(['success' => true]);
    }

    public function create()
    {
        $allDevelopers = DB::table('1_developer')->orderBy('name')->get();

        return view('games.create', compact('allDevelopers'));
    }

    public function store(Request $request)
    {
        $gameId = DB::table('1_games')->insertGetId([
            'title' => $request->input('title'),
            'release_year' => $request->input('release_year'),
            'steam_id' => $request->input('steam_id'),
            'gog_id' => $request->input('gog_id'),
            'wikidata_id' => $request->input('wikidata_id'),
            'igdb_id' => $request->input('igdb_id'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('games.edit', $gameId)->with('success', 'Game created! You can now add developers and literature.');
    }

    public function destroy($id)
    {
        // First delete related records (only the links, not the actual developers/literature)
        DB::table('1_game_developer')->where('game_id', $id)->delete();
        DB::table('1_literature')->where('game_id', $id)->delete();
        DB::table('3_pivot_game_period')->where('game_id', $id)->delete();
        DB::table('3_pivot_game_place')->where('game_id', $id)->delete();
        DB::table('3_pivot_game_gameplay_mode')->where('game_id', $id)->delete();
        DB::table('3_pivot_game_player_role')->where('game_id', $id)->delete();

        // Then delete the game
        DB::table('1_games')->where('game_id', $id)->delete();

        return response()->json(['success' => true]);
    }

    public function show($id, ZoteroService $zoteroService, IgdbService $igdbService)
    {
        $game = DB::table('1_games')->where('game_id', $id)->first();

        if (!$game) {
            abort(404);
        }

        $developers = DB::table('1_game_developer')
            ->join('1_developer', '1_game_developer.developer_id', '=', '1_developer.id')
            ->where('1_game_developer.game_id', $id)
            ->select('1_developer.*')
            ->get();

        $literature = DB::table('1_literature')
            ->where('game_id', $id)
            ->get();

        // Vocabulary data
        $periods = DB::table('3_pivot_game_period')
            ->join('2_periods', '3_pivot_game_period.period_id', '=', '2_periods.id')
            ->where('3_pivot_game_period.game_id', $id)
            ->select('2_periods.*')
            ->get();

        $places = DB::table('3_pivot_game_place')
            ->join('2_places', '3_pivot_game_place.place_id', '=', '2_places.id')
            ->where('3_pivot_game_place.game_id', $id)
            ->select('2_places.*')
            ->get();

        $gameplayModes = DB::table('3_pivot_game_gameplay_mode')
            ->join('2_gameplay_modes', '3_pivot_game_gameplay_mode.gameplay_mode_id', '=', '2_gameplay_modes.id')
            ->where('3_pivot_game_gameplay_mode.game_id', $id)
            ->select('2_gameplay_modes.*')
            ->get();

        $playerRoles = DB::table('3_pivot_game_player_role')
            ->join('2_player_roles', '3_pivot_game_player_role.player_role_id', '=', '2_player_roles.id')
            ->where('3_pivot_game_player_role.game_id', $id)
            ->select('2_player_roles.*')
            ->get();

        $tropes = DB::table('3_pivot_game_trope')
            ->join('2_tropes', '3_pivot_game_trope.trope_id', '=', '2_tropes.id')
            ->where('3_pivot_game_trope.game_id', $id)
            ->select('2_tropes.*')
            ->get();

        $persons = DB::table('3_pivot_game_person')
            ->join('2_persons', '3_pivot_game_person.person_id', '=', '2_persons.id')
            ->where('3_pivot_game_person.game_id', $id)
            ->select('2_persons.*')
            ->get();

        // IGDB data
        if ($game->igdb_id) {
            $game->igdb = $igdbService->getGameById($game->igdb_id);
        } else {
            $game->igdb = $igdbService->getGameData($game->title);
        }

        // Citations
        $zoteroIds = $literature->pluck('zotero_id')->implode(', ');
        $game->citations = $this->buildCitations($zoteroIds, $zoteroService);

        return view('games.show', compact('game', 'developers', 'literature', 'periods', 'places', 'gameplayModes', 'playerRoles', 'tropes', 'persons'));
    }

    public function edit($id)
    {
        $game = DB::table('1_games')->where('game_id', $id)->first();

        if (!$game) {
            abort(404);
        }

        $developers = DB::table('1_game_developer')
            ->join('1_developer', '1_game_developer.developer_id', '=', '1_developer.id')
            ->where('1_game_developer.game_id', $id)
            ->select('1_developer.*')
            ->get();

        $allDevelopers = DB::table('1_developer')->orderBy('name')->get();

        $literature = DB::table('1_literature')
            ->leftJoin('zotero_cache', '1_literature.zotero_id', '=', 'zotero_cache.item_key')
            ->where('game_id', $id)
            ->select('1_literature.*', 'zotero_cache.authors', 'zotero_cache.year', 'zotero_cache.citation')
            ->get();

        // Current vocabulary assignments
        $periods = DB::table('3_pivot_game_period')
            ->join('2_periods', '3_pivot_game_period.period_id', '=', '2_periods.id')
            ->where('3_pivot_game_period.game_id', $id)
            ->select('2_periods.*')
            ->get();

        $places = DB::table('3_pivot_game_place')
            ->join('2_places', '3_pivot_game_place.place_id', '=', '2_places.id')
            ->where('3_pivot_game_place.game_id', $id)
            ->select('2_places.*')
            ->get();

        $gameplayModes = DB::table('3_pivot_game_gameplay_mode')
            ->join('2_gameplay_modes', '3_pivot_game_gameplay_mode.gameplay_mode_id', '=', '2_gameplay_modes.id')
            ->where('3_pivot_game_gameplay_mode.game_id', $id)
            ->select('2_gameplay_modes.*')
            ->get();

        $playerRoles = DB::table('3_pivot_game_player_role')
            ->join('2_player_roles', '3_pivot_game_player_role.player_role_id', '=', '2_player_roles.id')
            ->where('3_pivot_game_player_role.game_id', $id)
            ->select('2_player_roles.*')
            ->get();

        $tropes = DB::table('3_pivot_game_trope')
            ->join('2_tropes', '3_pivot_game_trope.trope_id', '=', '2_tropes.id')
            ->where('3_pivot_game_trope.game_id', $id)
            ->select('2_tropes.*')
            ->get();

        $persons = DB::table('3_pivot_game_person')
            ->join('2_persons', '3_pivot_game_person.person_id', '=', '2_persons.id')
            ->where('3_pivot_game_person.game_id', $id)
            ->select('2_persons.*')
            ->get();

        // All vocabulary options
        $allPeriods = Period::with('children.children')->whereNull('parent_id')->orderBy('start_year')->get();
        $allPlaces = Place::with('children.children')->whereNull('parent_id')->orderBy('label_en')->get();
        $allGameplayModes = GameplayMode::orderBy('label_en')->get();
        $allPlayerRoles = PlayerRole::orderBy('label_en')->get();
        $allTropes = Trope::orderBy('label_en')->get();
        $allPersons = Person::orderBy('label_en')->get();

        return view('games.edit', compact(
            'game',
            'developers',
            'allDevelopers',
            'literature',
            'periods',
            'places',
            'gameplayModes',
            'playerRoles',
            'allPeriods',
            'allPlaces',
            'allGameplayModes',
            'allPlayerRoles',
            'tropes',
            'persons',
            'allTropes',
            'allPersons'
        ));
    }

    // Period methods
    public function addPeriod(Request $request, $id)
    {
        $periodId = $request->input('period_id');

        $exists = DB::table('3_pivot_game_period')
            ->where('game_id', $id)
            ->where('period_id', $periodId)
            ->exists();

        if (!$exists) {
            DB::table('3_pivot_game_period')->insert([
                'game_id' => $id,
                'period_id' => $periodId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function removePeriod($id, $periodId)
    {
        DB::table('3_pivot_game_period')
            ->where('game_id', $id)
            ->where('period_id', $periodId)
            ->delete();

        return response()->json(['success' => true]);
    }

    // Place methods
    public function addPlace(Request $request, $id)
    {
        $placeId = $request->input('place_id');

        $exists = DB::table('3_pivot_game_place')
            ->where('game_id', $id)
            ->where('place_id', $placeId)
            ->exists();

        if (!$exists) {
            DB::table('3_pivot_game_place')->insert([
                'game_id' => $id,
                'place_id' => $placeId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function removePlace($id, $placeId)
    {
        DB::table('3_pivot_game_place')
            ->where('game_id', $id)
            ->where('place_id', $placeId)
            ->delete();

        return response()->json(['success' => true]);
    }

    // Gameplay Mode methods
    public function addGameplayMode(Request $request, $id)
    {
        $modeId = $request->input('gameplay_mode_id');

        $exists = DB::table('3_pivot_game_gameplay_mode')
            ->where('game_id', $id)
            ->where('gameplay_mode_id', $modeId)
            ->exists();

        if (!$exists) {
            DB::table('3_pivot_game_gameplay_mode')->insert([
                'game_id' => $id,
                'gameplay_mode_id' => $modeId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function removeGameplayMode($id, $modeId)
    {
        DB::table('3_pivot_game_gameplay_mode')
            ->where('game_id', $id)
            ->where('gameplay_mode_id', $modeId)
            ->delete();

        return response()->json(['success' => true]);
    }

    // Player Role methods
    public function addPlayerRole(Request $request, $id)
    {
        $roleId = $request->input('player_role_id');

        $exists = DB::table('3_pivot_game_player_role')
            ->where('game_id', $id)
            ->where('player_role_id', $roleId)
            ->exists();

        if (!$exists) {
            DB::table('3_pivot_game_player_role')->insert([
                'game_id' => $id,
                'player_role_id' => $roleId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function removePlayerRole($id, $roleId)
    {
        DB::table('3_pivot_game_player_role')
            ->where('game_id', $id)
            ->where('player_role_id', $roleId)
            ->delete();

        return response()->json(['success' => true]);
    }

    protected function buildCitations(?string $zoteroIds, ZoteroService $zoteroService): array
    {
        if (empty($zoteroIds)) {
            return [];
        }
        $ids = explode(', ', $zoteroIds);
        $citationData = [];
        foreach ($ids as $id) {
            $id = trim($id);
            if (empty($id)) continue;
            $cached = ZoteroCache::find($id);
            if (!$cached) {
                $zoteroService->getCitation($id);
                $cached = ZoteroCache::find($id);
            }
            if ($cached) {
                $citationData[] = [
                    'key' => $id,
                    'authors' => $cached->authors,
                    'year' => $cached->year,
                    'citation' => $cached->citation,
                    'url' => "https://www.zotero.org/groups/" . config('services.zotero.group_id') . "/items/" . $id
                ];
            }
        }
        usort($citationData, function($a, $b) {
            // First sort by author
            $authorCompare = strcasecmp($a['authors'] ?? '', $b['authors'] ?? '');
            if ($authorCompare !== 0) {
                return $authorCompare;
            }
            // Then by year
            return ($a['year'] ?? '0') <=> ($b['year'] ?? '0');
        });
        return $citationData;
    }

    // Trope methods
    public function addTrope(Request $request, $id)
    {
        $tropeId = $request->input('trope_id');

        $exists = DB::table('3_pivot_game_trope')
            ->where('game_id', $id)
            ->where('trope_id', $tropeId)
            ->exists();

        if (!$exists) {
            DB::table('3_pivot_game_trope')->insert([
                'game_id' => $id,
                'trope_id' => $tropeId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function removeTrope($id, $tropeId)
    {
        DB::table('3_pivot_game_trope')
            ->where('game_id', $id)
            ->where('trope_id', $tropeId)
            ->delete();

        return response()->json(['success' => true]);
    }

    // Person methods
    public function addPerson(Request $request, $id)
    {
        $personId = $request->input('person_id');

        $exists = DB::table('3_pivot_game_person')
            ->where('game_id', $id)
            ->where('person_id', $personId)
            ->exists();

        if (!$exists) {
            DB::table('3_pivot_game_person')->insert([
                'game_id' => $id,
                'person_id' => $personId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function removePerson($id, $personId)
    {
        DB::table('3_pivot_game_person')
            ->where('game_id', $id)
            ->where('person_id', $personId)
            ->delete();

        return response()->json(['success' => true]);
    }
}
