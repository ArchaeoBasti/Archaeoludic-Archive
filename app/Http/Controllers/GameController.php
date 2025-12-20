<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\ZoteroService;
use App\Models\ZoteroCache;
use App\Services\IgdbService;
use Illuminate\Support\Facades\Http;

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

        return redirect(url('/games'));
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

        // IGDB data
        if ($game->igdb_id) {
            $game->igdb = $igdbService->getGameById($game->igdb_id);
        } else {
            $game->igdb = $igdbService->getGameData($game->title);
        }

        // Citations
        $zoteroIds = $literature->pluck('zotero_id')->implode(', ');
        $game->citations = $this->buildCitations($zoteroIds, $zoteroService);

        return view('games.show', compact('game', 'developers', 'literature'));
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
            ->where('game_id', $id)
            ->get();

        $vocabularies = DB::table('1_game_vocabulary')
            ->join('2_vocabulary', '1_game_vocabulary.voc_id', '=', '2_vocabulary.voc_id')
            ->where('1_game_vocabulary.game_id', $id)
            ->select('2_vocabulary.*')
            ->get();

        $allVocabularies = DB::table('2_vocabulary')
            ->orderBy('category')
            ->orderBy('term')
            ->get();

        return view('games.edit', compact('game', 'developers', 'allDevelopers', 'literature', 'vocabularies', 'allVocabularies'));
    }

    public function addVocabulary(Request $request, $id)
    {
        $vocId = $request->input('voc_id');

        $exists = DB::table('1_game_vocabulary')
            ->where('game_id', $id)
            ->where('voc_id', $vocId)
            ->exists();

        if (!$exists) {
            DB::table('1_game_vocabulary')->insert([
                'game_id' => $id,
                'voc_id' => $vocId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function removeVocabulary($id, $vocId)
    {
        DB::table('1_game_vocabulary')
            ->where('game_id', $id)
            ->where('voc_id', $vocId)
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
}
