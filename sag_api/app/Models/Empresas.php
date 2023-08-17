<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    protected $fillable = [
        'id',
        'nombre',
        'telefono',
        'correo'
    ];
    function Rutas(){
        return $this->hasMany(Rutas::class, 'id_empresa');
    }
    function paradas(){
        return $this->hasMany(Paradas::class, 'id_ruta');
    }
}
