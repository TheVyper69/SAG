<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


/* use model Rol */
use App\Models\Rol;

class RolController extends Controller
{
    public function index(){

    }

    public function store(Request $request){
        $rol = new Rol;
        $rol-> nombre = $request->input('nombre');
        $rol->save();
    }
    
    public function rolUpdate(Request $request){
        $request->validate([
            'id' => 'required',
            'nombre' => 'required'
            
            
        ]);

        $rol = Rol::find($request->id);
        $rol->nombre = $request->nombre;
        $rol->save();
        return response($rol, Response::HTTP_CREATED);
    }
    

    public function allRoles(){
        $rol = Rol::all();
        return response()->json($rol);
        // return response()->json(["roles" => $rol]);
    }
}

