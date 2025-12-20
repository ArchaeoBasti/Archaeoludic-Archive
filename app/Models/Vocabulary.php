<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    protected $table = '2_vocabulary';

    protected $primaryKey = 'voc_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'voc_id',
        'term',
        'description',
        'category',
    ];
}
