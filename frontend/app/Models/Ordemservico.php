<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordemservico extends Model
{
    protected $fillable = [
        'id',
        'cliente_id',
        'veiculo_id',
        'data_emissao',
        'status'
    ];
}