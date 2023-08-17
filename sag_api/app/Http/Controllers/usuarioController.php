<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use App\Mail\codigoEmail;


class usuarioController extends Controller
{
    /**
     * It validates the request, then it gets the email from the request, then it counts the number of
     * users with that email
     * 
     * @param Request request The request object.
     * 
     * @return The number of users with the same email.
     */
    public function usuarioCorreo(Request $request ){
        $request->validate([
            'correo'=>'required'
        ]);
        $correo = $request->correo;
        $usuario = DB::table('usuarios')
                            ->where('email', $correo)
                            ->count();

        return $usuario;

    }

    /**
     * I'm trying to get the data from the table "usuarios" where the "id_rol" is 2 and the
     * "id_empresa" is the same as the "id_empresa" of the user that is logged in
     * 
     * @param Request request The request object.
     */
    public function usuariosGerentes(Request $request){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $id_empresa = $user->id_empresa;
        $gerentes = DB::select("SELECT usuarios.id, usuarios.nombre, usuarios.email, 
                                       usuarios.telefono, usuarios.id_empresa,usuarios.estado, 
                                       empresas.nombre as nombreEmpresa FROM usuarios 
                                       inner join empresas where usuarios.id_rol = 2 
                                       AND empresas.id = '$id_empresa'");
        return response()->json( $gerentes);
        
    }
    public function allUsuarios(Request $request){
        $request->validate([
            'id_rol'=>'required'
        ]);
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $id_empresa = $user->id_empresa;
        $id_rol =  $request->id_rol;
        $usuario = DB::select("SELECT usuarios.id, usuarios.nombre, usuarios.email, usuarios.telefono, usuarios.id_empresa,usuarios.estado, empresas.nombre as nombreEmpresa FROM usuarios inner join empresas where usuarios.id_rol = '$id_rol' AND empresas.id = '$id_empresa' and empresas.id= usuarios.id_empresa");
        return response()->json( $usuario);
        
    }
    /**
     * It deletes a user from the database
     * 
     * @param Request request The request object.
     * 
     * @return 1
     */
    public function eliminarUser(Request $request){
        $usuario = Usuario::find($request->id);
        $usuario -> delete();

        return 1;
    }

    public function obtenerUsuarios(Request $request){
        $request->validate([
            'id'=>'required'
        ]);        
        $id = $request->id;
        $gerentes = DB::select("SELECT usuarios.id, usuarios.nombre, usuarios.email, usuarios.telefono, usuarios.id_rol, usuarios.id_empresa,usuarios.estado, empresas.nombre as nombreEmpresa FROM usuarios inner join empresas where usuarios.id = '$id' and empresas.id = usuarios.id_empresa");
        return response()->json( $gerentes);
    }

    /**
     * It updates the user's data, but it doesn't update the password
     * 
     * @param Request request The request object.
     * 
     * @return 1
     */
    public function updateGerente(Request $request){
        $request->validate([
            'id_rol' => 'required',
            'nombre' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'id_empresa' => 'required',
            'password' => 'required|confirmed'

        ]);

        $usuario = Usuario::find($request->id);
        $usuario->id_rol = $request->id_rol;
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->id_empresa = $request->id_empresa;       
        $usuario->password = bcrypt($request->password);
        $usuario->estado = $request->estado;
        $result = $usuario->save();

        return 1;
    }

    public function rolUser(Request $request){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $id_usuario = $user->id;
        $rol = Usuario::find($id_usuario);
        return response()->json($rol);
        // return response()->json($gerentes);

    }
    public function allGerentes(Request $request){
        
        $gerentes = DB::select("SELECT usuarios.id, usuarios.nombre, usuarios.email, usuarios.telefono, usuarios.id_empresa,usuarios.estado, empresas.nombre as nombreEmpresa FROM usuarios inner join empresas where usuarios.id_rol = 2 AND empresas.id=usuarios.id_empresa");
        return response()->json( $gerentes);
    }
    public function empleados(Request $request){
        
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $id_empresa = $user->id_empresa;
        
        $usuario = DB::select("SELECT usuarios.id, usuarios.nombre, usuarios.email, usuarios.telefono, usuarios.id_empresa,usuarios.estado, empresas.nombre as nombreEmpresa , rols.nombre as rolNombre FROM usuarios inner join rols inner join empresas where usuarios.id_rol >3 AND usuarios.id_empresa = '$id_empresa' and empresas.id= usuarios.id_empresa and rols.id = usuarios.id_rol" );
        return response()->json( $usuario);
    }

    public function codigoValidacion(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);
        $correo = $request->email;
        $usuarios=DB::table('usuarios')->where('email',$correo)->count();
        if($usuarios==1){
            $codigo = Usuario::generarNumeroAleatorio(6);
            $codigoV=DB::update("UPDATE usuarios SET codigo_validacion = '$codigo' where email = '$correo'");
            Mail::send('Mails.codigo', ['code' => $codigo], function ($message) use ($request) {
                $message->to($request->input('email'))->subject('Código de validación');
                
            });

            return response()->json(['message' => 'Código de validación enviado']);
            
        }else{
            return response()->json(['message' => 'Este correo no esta registrado'], 401);

        }

    }
    public function cambioPass(Request $request){
        $request->validate([
            'pass' => 'required|confirmed',
            'cod_val'=>'required'
        ]);
        
        $contra=bcrypt($request->pass);
        $cod= $request->cod_val;
        $user=DB::table('usuarios')->where('codigo_validacion',$cod)->count();
        if($user==1){
            $usuario=DB::update("UPDATE usuarios SET password='$contra' where codigo_validacion = '$cod'");
            return response()->json(['message' => 'Contraseña actualizada']);
        }else{
            return response()->json(['message' => 'Codigo no valido'], 401);
        }
    }

    
   
    public function cambiarContra(Request $request){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $request->validate([
            'pass' => 'required|confirmed'
        ]);
        
        $id_usuario = $user->id;
        $contra=bcrypt($request->pass);

        $usuario=DB::update("UPDATE usuarios SET password = '$contra' where id = '$id_usuario'");
        if($usuario){
            return response()->json(['message' => 'Contraseña actualizada']);
        }

    }
    public function usuarioActivo(Request $request){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $id_usuario = $user->id;
        

        $usuario = DB::table('usuarios')->where('id', $id_usuario)->where('estado', '=','s')->count();

        if($usuario==1){
            return response()->json(['message' => 'Usuario activo'],200);
            
        }else{
            return response()->json(['message' => 'Usuario no activo'],401);

        }



    }
}


