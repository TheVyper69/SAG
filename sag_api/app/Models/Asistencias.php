<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencias extends Model
{
    protected $fillable = [
        'id_usuario',
        'id_parada',
        'id_ruta'
        
    ];
}
