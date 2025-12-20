<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IgdbCache extends Model
{
    protected $table = 'igdb_cache';

    protected $fillable = [
        'game_title',
        'igdb_id',
        'slug',
        'description',
        'cover_url',
        'genres',
        'platforms',
        'developers',
        'publishers',
    ];
}
