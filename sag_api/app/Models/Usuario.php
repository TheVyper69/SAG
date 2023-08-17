<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;



class Usuario extends Authenticatable implements JWTSubject
{
    //use HasApiTokens, HasFactory, Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $fillable = [
        'id_rol',
        'nombre',
        'correo',
        'telefono',
        'ruta',
        'contraseña',
        'estado'
    ];
    public static function generarNumeroAleatorio($longitud)
    {
        $min = pow(10, $longitud - 1);
        $max = pow(10, $longitud) - 1;

        return random_int($min, $max);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'contraseña',
    ];
    
    
}
