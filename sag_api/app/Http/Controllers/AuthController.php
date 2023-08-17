<?php
/*
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Db;





class AuthController extends Controller
{
    public function register(Request $request){
        //validacion de datos
        $request->validate([
            'id_rol' => 'required',
            'nombre' => 'required',
            'correo' => 'required|email|unique:usuarios',
            'telefono' => 'required',
            'contraseña' => 'required|confirmed'

        ]);

        //alta usuario

        $usuario = new Usuario;
        $usuario->id_rol = $request->id_rol;
        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        $usuario->telefono = $request->telefono;
        $usuario->contraseña = sha1($request->contraseña);
        $usuario->save();


        //return response()->json(["message" => "metodo register ok"]);

        return response($usuario, Response::HTTP_CREATED);
    }
    public function login(Request $request){

        /*$credentials = $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required'

        ]);
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24);
            return response(["token"=>$token], Response::HTTP_ok)->withoutCookie($cookie);
        


        }else{
            return response(Response::HTTP_UNAUTHORIZED);
        }*/
       /* $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required'

        ]);

        $correo = $request->correo;
        $contraseña = sha1($request->contraseña);

        $login = DB::select("SELECT id FROM usuarios WHERE correo = '$correo' AND contraseña = '$contraseña'");
        
        return response()->json(["usuario" => $login]);
        

        
    }
    public function userProfile(Request $request){
        
    }
    public function logout(){
        
    }

    public function allUser(){
        $usuarios =db::select('select * from usuarios');
        return response()->json(["usuarios" => $usuarios]);
    }
}*/

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;



class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * The function takes the email and password from the request, and if the credentials are correct,
     * it returns a token
     * 
     * @return A token
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 480
        ]);
    }

    /* Creating a new user and saving it to the database. */
    public function register(Request $request){
        //validacion de datos
        $request->validate([
            'id_rol' => 'required',
            'nombre' => 'required',
            'email' => 'required|email|unique:usuarios',
            'telefono' => 'required',
            'id_empresa' => 'required',
            'password' => 'required|confirmed'

        ]);
        $estado = "s";

        //alta usuario

        $usuario = new User;
        $usuario->id_rol = $request->id_rol;
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->id_empresa = $request->id_empresa;
        $usuario->password = bcrypt($request->password);
        $usuario->estado = $estado;
        $result = $usuario->save();

        if($result){
            return 1;
        }else{
            return response($result);
        }
        //return response()->json(["message" => "metodo register ok"]);

        
    }
    
}

?>
