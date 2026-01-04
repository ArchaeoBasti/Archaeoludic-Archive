<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = '1_games';
    protected $primaryKey = 'game_id';

    protected $fillable = [
        'title',
        'release_year',
        'steam_id',
        'gog_id',
        'wikidata_id',
        'igdb_id',
    ];

    public function igdb()
    {
        return $this->hasOne(IgdbCache::class, 'igdb_id', 'igdb_id');
    }

    public function periods()
    {
        return $this->belongsToMany(Period::class, '1_game_period', 'game_id', 'period_id');
    }

    public function places()
    {
        return $this->belongsToMany(Place::class, '1_game_place', 'game_id', 'place_id');
    }

    public function gameplayModes()
    {
        return $this->belongsToMany(GameplayMode::class, '1_game_gameplay_mode', 'game_id', 'gameplay_mode_id');
    }

    public function playerRoles()
    {
        return $this->belongsToMany(PlayerRole::class, '1_game_player_role', 'game_id', 'player_role_id');
    }
}
