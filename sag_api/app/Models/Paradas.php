<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paradas extends Model
{
    protected $fillable = [
        'id_ruta',
        'nombre',
        'coordenadas_x',
        'coordenadas_y'
        
    ];
}
