<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Services\IgdbService;

class HomeController extends Controller
{
    public function index(IgdbService $igdbService)
    {
        // Statistiken
        $stats = [
            'games' => DB::table('1_games')->count(),
            'developers' => DB::table('1_developer')->count(),
            'citations' => DB::table('1_literature')->distinct('zotero_id')->count('zotero_id'),
            'vocabularies' => DB::table('2_vocabulary')->count(),
        ];

        // Die 6 neuesten Spiele mit allen nötigen Daten
        $latestGames = DB::table('1_games')
            ->leftJoin('1_literature', '1_games.game_id', '=', '1_literature.game_id')
            ->select(
                '1_games.game_id',
                '1_games.title',
                '1_games.release_year',
                '1_games.steam_id',
                '1_games.gog_id',
                '1_games.wikidata_id',
                '1_games.igdb_id',
                '1_games.created_at',
                DB::raw('COUNT(DISTINCT 1_literature.zotero_id) as literature_count')
            )
            ->groupBy('1_games.game_id', '1_games.title', '1_games.release_year', '1_games.steam_id', '1_games.gog_id', '1_games.wikidata_id', '1_games.igdb_id', '1_games.created_at')
            ->orderByDesc('1_games.created_at')
            ->limit(5)
            ->get();

        // IGDB-Daten und LOD-Count hinzufügen
        foreach ($latestGames as $game) {
            // IGDB-Daten
            if ($game->igdb_id) {
                $game->igdb = $igdbService->getGameById($game->igdb_id);
            } else {
                $game->igdb = $igdbService->getGameData($game->title);
            }

            // LOD-Count berechnen
            $lod_count = 0;
            if (!empty($game->steam_id)) $lod_count++;
            if (!empty($game->gog_id)) $lod_count++;
            if (!empty($game->wikidata_id)) $lod_count++;
            if ($game->igdb && $game->igdb->slug) $lod_count++;
            $game->lod_count = $lod_count;
        }

        return view('home', compact('stats', 'latestGames'));
    }
}
