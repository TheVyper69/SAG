<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rutas;
use App\Models\Paradas;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\PostResources;


class RutasController extends Controller
{
    public function rutaRegister(Request $request){
        $request->validate([

            'id_empresa' => 'required',
            'nombre' => 'required'
        ]);

        $ruta = new Rutas;
        $ruta->id_empresa = $request->id_empresa; 
        $ruta->nombre = $request->nombre;
        $ruta->save();
        if($result){
            return response($result, Response::HTTP_OK);
        }else{
            return 1;
        }
        
    }

    public function rutaUpdate(Request $request){
        $request->validate([
            'id' => 'required',
            'nombre' => 'required'
            
        ]);

        $ruta = Rutas::find($request->id);
        $ruta->nombre = $request->nombre;
        $ruta->save();
        return 1;
    }

    /**
     * It deletes a row from the database
     * 
     */
    public function rutaDestroy(Request $request){
        $ruta = Rutas::find($request->id);
        $ruta -> delete();
        return 1;
    }

    public function allRutas(Request $request){
        $ruta = Rutas::all();
        return response()->json($ruta);

    }

    /**
     * It returns a json response of the rutas table where the id_empresa is equal to the id_empresa of
     * the user
     * 
     * @param Request request The request object.
     */
    public function rutaEmpresa(Request $request){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $id_empresa = $user->id_empresa;

        $ruta = DB::select("SELECT * from rutas where id_empresa = '$id_empresa'");

        return response()->json($ruta);
        
    }

    public function rutasEmpresa(Request $request){
        
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $id_empresa = $user->id_empresa;
        
        $rutas = DB::select("SELECT id, nombre FROM rutas Where id_empresa = '$id_empresa'");
        return response()->json( $rutas);

    }

    public function obtenerRuta(Request $request){
        $request->validate([
            'id'=>'required'
        ]);        
        $id = $request->id;
        $rutas = DB::select("SELECT * FROM rutas where id='$id'");
        return response()->json( $rutas);
    }
    public function rutaNombre(Request $request){
        $request->validate([
            'nombre'=>'required'
        ]); 
        $nombre = $request->nombre;
        $rutas = Rutas::select('*')->where('nombre',$nombre)->first();
        return response()->json( $rutas);

    }

    /**
     * It returns the route collection with the stops that belong to it.
     * 
     * @param Request request The request object.
     */
    public function rutaCollection(Request $request){
        $ruta= Rutas::with(['paradas' => function ($query){
            $query->select('id','id_ruta','nombre as nombreParada','coordenadas_x', 'created_at', 'updated_at');
        }])->get();
        return response()->json($ruta);

    }

    public function rutasParadas(Request $request){

        $ruta = Rutas::all();
        $paradas = Paradas::all();
        return response()->json([
            "rutas" => $ruta,
            "paradas" => $paradas
        ]);
        
    }
    public function rutaCollectionEmpresa(Request $request){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $id_empresa = $user->id_empresa;

        $ruta= Rutas::with(['paradas' => function ($query){
            $query->select('id','id_ruta','nombre as nombreParada','coordenadas_x', 'created_at', 'updated_at');
        }])->where('id_empresa', $id_empresa)->get();
        return response()->json( ["rutas" => $ruta]);

    }
}
