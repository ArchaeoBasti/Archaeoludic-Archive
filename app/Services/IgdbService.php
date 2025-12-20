<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\IgdbCache;

class IgdbService
{
    protected string $clientId;
    protected string $clientSecret;

    public function __construct()
    {
        $this->clientId = config('services.igdb.client_id');
        $this->clientSecret = config('services.igdb.client_secret');
    }

    protected function getAccessToken(): string
    {
        return Cache::remember('igdb_access_token', 3600, function () {
            $response = Http::post('https://id.twitch.tv/oauth2/token', [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
            ]);

            return $response->json()['access_token'];
        });
    }

    public function getGameById(int $igdbId): ?IgdbCache
    {
        // Erst im Cache schauen
        $cached = IgdbCache::where('igdb_id', $igdbId)->first();
        if ($cached) {
            return $cached;
        }

        // Von IGDB holen
        $token = $this->getAccessToken();

        $response = Http::withHeaders([
            'Client-ID' => $this->clientId,
            'Authorization' => 'Bearer ' . $token,
        ])->withBody(
            'where id = ' . $igdbId . '; fields name,url,summary,cover.url,genres.name,platforms.name,involved_companies.company.name,involved_companies.developer,involved_companies.publisher;',
            'text/plain'
        )->post('https://api.igdb.com/v4/games');

        if ($response->failed() || empty($response->json())) {
            return null;
        }

        $game = $response->json()[0];

        return $this->saveGameData($game);
    }

    public function getGameData(string $gameTitle): ?IgdbCache
    {
        // Erst im Cache schauen
        $cached = IgdbCache::where('game_title', $gameTitle)->first();
        if ($cached) {
            return $cached;
        }

        // Von IGDB holen
        $token = $this->getAccessToken();

        $response = Http::withHeaders([
            'Client-ID' => $this->clientId,
            'Authorization' => 'Bearer ' . $token,
        ])->withBody(
            'search "' . $gameTitle . '"; fields name,url,summary,cover.url,genres.name,platforms.name,involved_companies.company.name,involved_companies.developer,involved_companies.publisher; limit 1;',
            'text/plain'
        )->post('https://api.igdb.com/v4/games');

        if ($response->failed() || empty($response->json())) {
            return null;
        }

        $game = $response->json()[0];

        return $this->saveGameData($game);
    }

    protected function saveGameData(array $game): IgdbCache
    {
        $genres = collect($game['genres'] ?? [])
            ->pluck('name')
            ->join(', ');

        $platforms = collect($game['platforms'] ?? [])
            ->pluck('name')
            ->join(', ');

        $companies = collect($game['involved_companies'] ?? []);

        $developers = $companies
            ->filter(fn($c) => $c['developer'] ?? false)
            ->map(fn($c) => $c['company']['name'] ?? '')
            ->join(', ');

        $publishers = $companies
            ->filter(fn($c) => $c['publisher'] ?? false)
            ->map(fn($c) => $c['company']['name'] ?? '')
            ->join(', ');

        $coverUrl = isset($game['cover']['url'])
            ? 'https:' . str_replace('t_thumb', 't_cover_big', $game['cover']['url'])
            : null;

        return IgdbCache::create([
            'game_title' => $game['name'] ?? 'Unknown',
            'igdb_id' => $game['id'] ?? null,
            'slug' => $game['url'] ?? null,
            'description' => $game['summary'] ?? null,
            'cover_url' => $coverUrl,
            'genres' => $genres ?: null,
            'platforms' => $platforms ?: null,
            'developers' => $developers ?: null,
            'publishers' => $publishers ?: null,
        ]);
    }

    public function searchGames(string $query, int $limit = 10): array
    {
        $token = $this->getAccessToken();

        $response = Http::withHeaders([
            'Client-ID' => $this->clientId,
            'Authorization' => 'Bearer ' . $token,
        ])->withBody(
            'search "' . $query . '"; fields id,name,first_release_date; limit ' . $limit . ';',
            'text/plain'
        )->post('https://api.igdb.com/v4/games');

        if ($response->failed()) {
            return [];
        }

        $games = $response->json();

        return collect($games)->map(function ($game) {
            $year = isset($game['first_release_date'])
                ? date('Y', $game['first_release_date'])
                : 'Unbekannt';
            return [
                'id' => $game['id'],
                'name' => $game['name'],
                'year' => $year,
            ];
        })->toArray();
    }
}
