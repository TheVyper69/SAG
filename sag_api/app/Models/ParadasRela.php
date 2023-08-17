<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParadasRela extends Model
{
    protected $fillable = [
        'id_parada',
        'id_parada_anterior',
        'tiempo'
        
    ];
    use HasFactory;
}
