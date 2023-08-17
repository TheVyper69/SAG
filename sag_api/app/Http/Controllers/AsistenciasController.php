<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencias;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;



class AsistenciasController extends Controller
{
    /**
     * A function that allows you to register the attendance of a user in a stop.
     * 
     * @param Request request The request object.
     */
    public function asistenciaRegister(Request $request){
        //validacion de datos
        $request->validate([
           'id_parada' => 'required'
          
       ]);
       $token = JWTAuth::getToken();
       $user = JWTAuth::toUser($token);

       //alta parada

       $asistencia = new Asistencias;
       $asistencia->id_usuario = $user->id; 
       $asistencia->id_parada = $request->id_parada;
       $asistencia->save();


       //return response()->json(["message" => "metodo register ok"]);

       return response($asistencia, Response::HTTP_CREATED);
   }

   public function asistencia(Request $request){
    $request->validate([
        'id_ruta' => 'required'
        
       
    ]);
    $asistencia = $request->id_ruta;
    $asistencias = DB::select("SELECT * FROM `asistencias` INNER JOIN paradas INNER JOIN rutas WHERE paradas.id_ruta = '$asistencia' and rutas.id = '$asistencia'");
    
    return response()->json(["asistencias" => $asistencias]);
    
   }
   /**
    * I want to get the last 7 days of attendance of the users of the company that the user is logged
    * in
    * 
    * @param Request request The request object.
    */
   public function asistenciaUser(Request $request){
    
    $token = JWTAuth::getToken();
    $user = JWTAuth::toUser($token);

    $id_empresa = $user->id_empresa;
    $asistencias = DB::select("SELECT usuarios.nombre, paradas.nombre as parada_nombre,rutas.nombre 
                                      as ruta_nombre, DATE_FORMAT(asistencias.created_at, '%d/%m/%Y %H:%i:%s') AS created_at FROM asistencias 
                                      INNER JOIN usuarios INNER JOIN paradas ON asistencias.id_parada = paradas.id  
                                      INNER JOIN rutas ON paradas.id_ruta=rutas.id WHERE asistencias.id_usuario = usuarios.id 
                                      AND usuarios.id_empresa='$id_empresa' AND asistencias.created_at>= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
                                      ORDER BY asistencias.created_at DESC;");
    
    return response()->json($asistencias);
    
   }

   public function onlyUser(Request $request){
    
    $token = JWTAuth::getToken();
    $user = JWTAuth::toUser($token);

    $id_user = $user->id;
    $asistencias = DB::select("SELECT usuarios.nombre, paradas.nombre as parada_nombre,rutas.nombre as ruta_nombre, DATE_FORMAT(asistencias.created_at, '%d/%m/%Y %H:%i:%s') AS created_at FROM asistencias INNER JOIN usuarios ON asistencias.id_usuario = usuarios.id INNER JOIN paradas ON asistencias.id_parada = paradas.id  INNER JOIN rutas ON paradas.id_ruta=rutas.id WHERE asistencias.id_usuario = '$id_user' AND asistencias.created_at>= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ORDER BY asistencias.created_at DESC;");
    
    return response()->json($asistencias);
    
   }

   public function pasajero(Request $request){
    $request->validate([
        'id_parada' => 'required',
        'tiempo'=>'required' 
    ]);
    $idParada = $request->id_parada;
    $tiempo = $request->tiempo;
    $asistencias=DB::table('asistencias')->select('created_at')->whereRaw("created_at >= DATE_SUB(NOW(), INTERVAL '$tiempo' MINUTE)")->where('id_parada',$idParada)->orderBy('created_at','ASC')->first();
    if($asistencias != ""){
        return response()->json( $asistencias);
    }else{
        return response()->json(['message' => 'No hay transporte'], 401);

    }

   }
}
