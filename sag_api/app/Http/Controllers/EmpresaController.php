<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresas;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;



class EmpresaController extends Controller
{
    public function empresaRegister(Request $request){
        //validacion de datos
        $request->validate([
            
            'nombre' => 'required',
            'telefono' => 'required',
            'correo' => 'required|email'
            

        ]);
        $empresa = new Empresas;
        $empresa->nombre = $request->nombre;
        $empresa->telefono = $request->telefono;
        $empresa->correo = $request->correo;  
        $result = $empresa->save();

        if($result){
            return 1;
        }else{
            return 2;
        }
           
    }

    public function update(Request $request){
        $request->validate([
            'id' => 'required',
            'nombre' => 'required',
            'telefono' => 'required',
            'correo' => 'required'

        ]);

        $empresa = Empresas::find($request->id);
        $empresa->nombre = $request->nombre;
        $empresa->telefono = $request->telefono;
        $empresa->correo = $request->correo; 
        $empresa->save();

        return 1; 
    }
    public function obtenerEmpresa(Request $request){
        $request->validate([
            'id'=>'required'
        ]);
        $id = $request->id;
        $empresa = DB::select("SELECT id, nombre,telefono, correo FROM empresas WHERE id = '$id'");
        return response()->json($empresa);


    }

    public function destroy(Request $request){
        $empresa = Empresas::find($request->id);
        $empresa -> delete();

        return 1;

    }
    public function allEmpresas(){
        $empresa = Empresas::all();
        return response()->json($empresa);

    }

    public function empresaCorreo(Request $request ){
        $request->validate([
            'correo'=>'required'
        ]);
        $correo = $request->correo;
        $empresa = DB::table('empresas')
                            ->where('correo', $correo)
                            ->count();

        return $empresa;

    }
    public function empresaUser(){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $id_empresa = $user->id_empresa;
        $empresa = DB::select("SELECT * FROM empresas WHERE id='$id_empresa'");
        return response()->json($empresa);

    }

    public function empresasCollection(Request $request){
        $empresa = Empresas::with(['rutas'=>function($query){
            $query->select('id', 'id_empresa', 'nombre as nombreRuta');
            $query->with(['paradas'=>function($q){
                $q->select('id','id_ruta','nombre as nombreParada');
            }]);
        }])->get();

        return response()->json( ["empresas" => $empresa]);

    }

}
