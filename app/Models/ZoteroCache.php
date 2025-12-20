<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoteroCache extends Model
{
    protected $table = 'zotero_cache';

    protected $primaryKey = 'item_key';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'item_key',
        'authors',
        'year',
        'citation',
        'title',
        'publication',
        'volume',
        'issue',
        'pages',
        'publisher',
        'place',
        'doi',
        'url',
        'item_type',
    ];
}
