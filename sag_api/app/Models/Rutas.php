<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rutas extends Model
{

    protected $fillable = [
        'id_empresa',
        'nombre'
       
    ]; 

    function paradas(){
        return $this->hasMany(Paradas::class, 'id_ruta');
    }
}


