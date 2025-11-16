<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'id',
        'nome',
        'marca',
        'valor',
        'ativo'
    ];
}
