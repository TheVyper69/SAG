<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paradas;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;



class ParadasController extends Controller
{
    /**
     * A function that allows you to register a stop in the database.
     * 
     * @param Request request The request object.
     */
    public function paradasRegister(Request $request){
         //validacion de datos
         $request->validate([
            'id_ruta' => 'required',
            'nombre' => 'required',
            'coordenadas_x'=>'required',
            'coordenadas_y'=>'required'
            
        ]);

        //alta parada

        $parada = new Paradas;
        $parada->id_ruta = $request->id_ruta; 
        $parada->nombre = $request->nombre;
        $parada ->coordenadas_x = $request->coordenadas_x;
        $parada ->coordenadas_y = $request->coordenadas_y;
        $parada->save();

        return response()->json($parada);
    }
    
    /**
     * *Actualizacion de paradas*
     * 
     * @param Request request The request object.
     */
    public function paradasUpdate(Request $request){
        $request->validate([
            'id' => 'required',
            'id_ruta' => 'required',
            'nombre' => 'required',
            'coordenadas_x'=>'required',
            
            
        ]);

        $parada = Paradas::find($request->id);
        $parada->id_ruta = $request->id_ruta; 
        $parada->nombre = $request->nombre;
        $parada ->coordenadas_x = $request->coordenadas_x;
       
        $result=$parada->save();
        if($result){
            return 0;
        }else{
            return 1;
        }
    }

    /**
     * It deletes a stop from the database
     * 
     * @param Request request The request object.
     * 
     * @return 1
     */
    public function paradasDelete(Request $request){
        $parada = Paradas::find($request->id);
        $parada -> delete();

        return 1;

    }
    public function allParadas(){
        $parada = Paradas::all();
        return response()->json(["paradas" => $parada]);

    }
    

    /**
     * It returns a json response of the query result
     */
    public function paradasEmpresa(){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $id_empresa = $user->id_empresa;
        $parada = DB::select("SELECT paradas.id as id,
                             paradas.nombre, paradas.id_ruta, 
                             paradas.coordenadas_x,paradas.coordenadas_y, rutas.nombre as rutasNombre 
                                FROM paradas inner join rutas 
                                where paradas.id_ruta = rutas.id 
                                and rutas.id_empresa='$id_empresa'");
        return response()->json( $parada);

    }

    
    public function obtenerParada(Request $request){
        $request->validate([
            'id'=>'required'
        ]);        
        $id = $request->id;
        $parada = DB::select("SELECT * FROM paradas where id='$id'");
        return response()->json( $parada);
    }

    public function compararParada(Request $request){
        $request->validate([
            'coordenadas_x' => 'required',
            'coordenadas_y' => 'required'
        ]);
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $id_empresa = $user->id_empresa;


        $coordenadasx = $request->coordenadas_x;
        $coordenadasy = $request->coordenadas_y;

        $parada = DB::table('paradas')->join('rutas','rutas.id' ,'paradas.id_ruta')->select(DB::raw('paradas.id as id'))->where('rutas.id_empresa', $id_empresa)->where('coordenadas_x','LIKE',$coordenadasx.'%')->where('coordenadas_y','LIKE',$coordenadasy.'%')->first();
        return response()->json($parada);

    }

    public function paradaPasajero(Request $request){
        $request->validate([
            'id'=>'required',
           
        ]);
        $id = $request->id;
        

        $parada = DB::table('paradas')->where('id', $id)->first();
        return response()->json($parada);

    }

    public function nombreParada(Request $request){
        $request->validate([
            'nombre'=>'required',
            'id_ruta'=>'required'
            
        ]);
        
        $nombre = $request->nombre;
        $idRuta = $request->id_ruta;

        $parada = DB::table('paradas')->where('nombre',$nombre)->where('id_ruta',$idRuta)->first();
        return response()->json($parada);


    }



}
