<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParadasRela;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;


class ParadasRelaController extends Controller
{
    public function registro(Request $request){
        $request->validate([
            'id_parada' => 'required',
            'id_parada_anterior' => 'required',
            'tiempo'=>'required'
            
        ]);
        $parada = new ParadasRela;
        $parada->id_parada = $request->id_parada; 
        $parada->id_parada_anterior = $request->id_parada_anterior;
        $parada ->tiempo = $request->tiempo;
        $result=$parada->save();
        if($result){
            return 0;
        }else{
            return 1;
        }

    }

    public function paradasRela(Request $request){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $id_empresa = $user->id_empresa;

        $parada=DB::table('paradas_relas')->join('paradas as p1','p1.id','paradas_relas.id_parada')->join('paradas as p2','p2.id','paradas_relas.id_parada_anterior')->join('rutas','rutas.id','p1.id_ruta')->select('paradas_relas.id','p1.nombre as paradaPrincipal','p2.nombre as paradaSecundaria','paradas_relas.tiempo')->where('rutas.id_empresa',$id_empresa)->get();

        return response()->json($parada);

    }

    public function obtenerParadaRela(Request $request){
        $request->validate([
            'id' => 'required'
            
        ]);
        $id = $request->id;

        $parada=DB::table('paradas_relas')->select('id','id_parada','id_parada_anterior','tiempo')->where('id',$id)->get();

        return response()->json($parada);

    }
    public function tiempo(Request $request){
        $request->validate([
            'id_parada' => 'required',
            
        ]);
        $id_parada = $request->id_parada; 
        $tiempo=DB::table('paradas_relas')->where('id_parada', $id_parada)->first();
        return response()->json($tiempo);

    }
    public function paradasRelaDelete(Request $request){
        $parada = ParadasRela::find($request->id);
        $parada -> delete();

        if($parada){
            return 1;

        }else{
            return 2;
        }

    }
    public function paradasrelaUpdate(Request $request){
        $request->validate([
            'id' => 'required',
            'id_parada' => 'required',
            'id_parada_anterior' => 'required',
            'tiempo'=>'required'
            
            
        ]);

        $parada = ParadasRela::find($request->id);
        $parada->id_parada = $request->id_parada; 
        $parada->id_parada_anterior = $request->id_parada_anterior;
        $parada ->tiempo = $request->tiempo;
       
        $result=$parada->save();
        if($result){
            return 0;
        }else{
            return 1;
        }
    }
}
