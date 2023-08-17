<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Dompdf\Dompdf;
use Tymon\JWTAuth\Facades\JWTAuth;
use Fruitcake\Cors\HandleCors;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/*Rol*/
Route::resource('rol', RolController::class);
Route::post('rolUpdate', 'RolController@rolUpdate');
Route::get('allRoles', 'RolController@allRoles');


/* USUSARIO 

Route::post('login', 'AuthController@login');*/
Route::get('usuarios','AuthController@allUser');

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    



});

Route::post('correoUser', 'usuarioController@usuarioCorreo');
Route::get('gerenteUser', 'usuarioController@usuariosGerentes');
Route::delete('eliminarUser', 'usuarioController@eliminarUser');
Route::get('obtenerUser', 'usuarioController@obtenerUsuarios');
Route::post('updateGerente', 'usuarioController@updateGerente');
Route::post('login', 'usuarioController@login');
Route::get('users', 'usuarioController@allUsuarios');
Route::get('rolUser', 'usuarioController@rolUser');
Route::get('allGerente', 'usuarioController@allGerentes');
Route::get('empleado', 'usuarioController@empleados');
Route::post('codigoValidacion', 'usuarioController@codigoValidacion');
Route::post('cambioPass', 'usuarioController@cambioPass');
Route::post('cambiarContra', 'usuarioController@cambiarContra');

Route::post('usuarioActivo', 'usuarioController@usuarioActivo');












/*EMPRESA*/
Route::post('empresaRegister', 'EmpresaController@empresaRegister');
Route::post('empresaUpdate', 'EmpresaController@update');
Route::delete('empresaDelete', 'EmpresaController@destroy');
Route::get('allEmpresas', 'EmpresaController@allEmpresas');
Route::post('correoEmpresa', 'EmpresaController@empresaCorreo');
Route::get('obtenerEmpresa', 'EmpresaController@obtenerEmpresa');
Route::get('empresaUser', 'EmpresaController@empresaUser');
Route::get('empresasCollection', 'EmpresaController@empresasCollection');




/*RUTAS*/
Route::post('rutasRegister', 'RutasController@rutaRegister');
Route::post('rutasUpdate', 'RutasController@rutaUpdate');
Route::delete('rutasDelete', 'RutasController@rutaDestroy');
Route::get('allRutas', 'RutasController@allRutas');
// Route::post('rutasEmpresa', 'RutasController@rutaEmpresa');
Route::get('rutasEmpresa', 'RutasController@rutasEmpresa');
Route::get('obtenerRuta', 'RutasController@obtenerRuta');
Route::get('rutaCollection', 'RutasController@rutaCollection');
Route::get('rutasParadas', 'RutasController@rutasParadas');

Route::post('rutaNombre', 'RutasController@rutaNombre');

Route::get('rutaCollectionEmpresa', 'RutasController@rutaCollectionEmpresa');







/*paradas*/
Route::Post('paradasRegister', 'ParadasController@paradasRegister');
Route::Post('paradasUpdate', 'ParadasController@paradasUpdate');
Route::delete('paradasDelete', 'ParadasController@paradasDelete');
Route::get('allParadas', 'ParadasController@allParadas');
Route::get('paradasEmpresa', 'ParadasController@paradasEmpresa');
Route::get('obtenerParada', 'ParadasController@obtenerParada');
Route::Post('compararParada', 'ParadasController@compararParada');
Route::Post('paradaPasajero', 'ParadasController@paradaPasajero');
Route::Post('registroParada', 'ParadasRelaController@registro');
Route::Post('nombreParada', 'ParadasController@nombreParada');
Route::Post('tiempo', 'ParadasRelaController@tiempo');
Route::Post('paradasRela', 'ParadasRelaController@paradasRela');
Route::get('obtenerParadaRela', 'ParadasRelaController@obtenerParadaRela');
Route::delete('paradasRelaDelete', 'ParadasRelaController@paradasRelaDelete');
Route::Post('paradasrelaUpdate', 'ParadasRelaController@paradasrelaUpdate');





/*asistencia*/
Route::post('asistenciaRegister', 'AsistenciasController@asistenciaRegister');
Route::post('asistencia', 'AsistenciasController@asistencia');
Route::get('asistenciaUser', 'AsistenciasController@asistenciaUser');
Route::get('onlyUser', 'AsistenciasController@onlyUser');
Route::post('pasajero', 'AsistenciasController@pasajero');


Route::get('/pdf', function () {

    $user = JWTAuth::parseToken()->authenticate();

    
    // Generar contenido HTML
    $usuarios = App\Models\Usuario::join('rols','rols.id','usuarios.id_rol')->select('usuarios.nombre as nombreEmpleado','usuarios.email as correo', 'rols.nombre as nombreRol' )->where('id_empresa',$user->id_empresa)->get();
    $html = '<h1>Lista de empleados</h1>';
    $html .= '<style> body {
        margin-left: 80px;
      } table { margin: auto;    font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
        font-size: 12px;    margin: 45px;     width: 480px; text-align: left;    border-collapse: collapse; }
    
    th {     font-size: 13px;     font-weight: normal;     padding: 8px;     background: #b9c9fe;
        border-top: 4px solid #aabcfe;    border-bottom: 1px solid #fff; color: #039; }
    
    td {    padding: 8px;     background: #e8edff;     border-bottom: 1px solid #fff;
        color: #669;    border-top: 1px solid transparent; }
    
    tr:hover td { background: #d0dafd; color: #339; } </style>';
    $html .= '<table>';
    $html .= '<tr><th>Nombre</th><th>Email</th><th>Rol</th></tr>';

    foreach ($usuarios as $usuario) {
        $html .= '<tr><td>' . $usuario->nombreEmpleado . '</td><td>' . $usuario->correo . '</td><td>' . $usuario->nombreRol . '</td></tr>';
    }

    $html .= '</table>';


    // Crear instancia de Dompdf
    $dompdf = new Dompdf();
    
    

    // Cargar contenido HTML en Dompdf
    $dompdf->loadHtml($html);

    // Renderizar PDF
    $dompdf->render();

    // Devolver archivo PDF al cliente
    return response($dompdf->output(), 200)
        ->header('Content-Type', 'application/pdf');
})->middleware('jwt.auth');

Route::middleware([HandleCors::class])->post('/asistenciasPdf', function (Request $request) {

    $request->validate([
        'fechaI' => 'required',
        'fechaF' => 'required'
       
    ]);
    
    $user = JWTAuth::parseToken()->authenticate();

    $fechaI = $request->fechaI;
    $fechaF = $request->fechaF;
    $fecha_objeto1 = new DateTime($fechaI);
    $fechaInicio = $fecha_objeto1->format('d/m/Y');
    $fecha_objeto2 = new DateTime($fechaF);
    $fechaFinal = $fecha_objeto2->format('d/m/Y');

    
    // Generar contenido HTML
    $rutas = App\Models\Rutas::where('id_empresa',$user->id_empresa)->get();
    $html = '<h1>Registro de vueltas</h1>';
    $html .= '<style> body {
        margin-left: 80px;
      } table { margin: auto;    font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
        font-size: 12px;    margin: 45px;     width: 480px; text-align: left;    border-collapse: collapse; }
    
    th {     font-size: 13px;     font-weight: normal;     padding: 8px;     background: #b9c9fe;
        border-top: 4px solid #aabcfe;    border-bottom: 1px solid #fff; color: #039; }
    
    td {    padding: 8px;     background: #e8edff;     border-bottom: 1px solid #fff;
        color: #669;    border-top: 1px solid transparent; }
    
    tr:hover td { background: #d0dafd; color: #339; } </style>';
    $html.= '<h2>Fecha: '.$fechaInicio.' al '.$fechaFinal.'</h2>';
    
    foreach($rutas as $ruta){
        $html .= '<h3>Ruta: '. $ruta->nombre .'</h3>';
        
        $html .= '<table>';
        $html .= '<tr><th>Chofer</th><th>Vueltas</th></tr>';
        $id_empresa = 64;
        $paradas = App\Models\Paradas::where('id_ruta',$ruta->id)->count();
        $usuarios = App\Models\Usuario::where('id_empresa',$user->id_empresa)->where('id_rol','4')->get();

        foreach ($usuarios as $usuario) {
            

            $asistencias = App\Models\Asistencias::join('paradas', 'paradas.id','asistencias.id_parada')->join('usuarios', 'usuarios.id', 'asistencias.id_usuario')->where('usuarios.id_empresa',$user->id_empresa)->where('usuarios.id_rol','4')->where('paradas.id_ruta',$ruta->id)->where('id_usuario',$usuario->id)->whereBetween('asistencias.created_at', [$fechaI, $fechaF])->count();

            if($asistencias>=1){
                $vueltas = $asistencias / $paradas;
                $html .= '<tr><td>' . $usuario->nombre . '</td><td>' . $vueltas . '</td></tr>';
                // $html .= '<h4> vueltas: '.$vueltas.'</h4>';
            }else{
                $html .= '<tr><td>' . $usuario->nombre . '</td><td>' . $asistencias . '</td></tr>';

                // $html .= '<h4> vueltas: '.$asistencias.'</h4>';

            }
   
        }
        $html .= '</table>';
        




    }

    // Crear instancia de Dompdf
    $dompdf = new Dompdf();
    
    // Cargar contenido HTML en Dompdf
    $dompdf->loadHtml($html);

    // Renderizar PDF
    $dompdf->render();

    // Devolver archivo PDF al cliente
    return response($dompdf->output(), 200)
        ->header('Content-Type', 'application/pdf');
})->middleware('jwt.auth');

Route::middleware([HandleCors::class])->post('/asistenciaPDF', function (Request $request) {

    $request->validate([
        'fechaI' => 'required'
       
    ]);
    
    $user = JWTAuth::parseToken()->authenticate();

    $fechaI = $request->fechaI;
    $fecha1 = $fechaI.' 00:00:00';
    $fecha2 = $fechaI.' 23:59:59';
    $fecha_objeto1 = new DateTime($fechaI);
    $fecha = $fecha_objeto1->format('d/m/Y');


    
    // Generar contenido HTML
    $rutas = App\Models\Rutas::where('id_empresa',$user->id_empresa)->get();
    $html = '<h1>Registro de vueltas</h1>';
    $html .= '<style> body {
        margin-left: 80px;
      } table { margin: auto;    font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
        font-size: 12px;    margin: 45px;     width: 480px; text-align: left;    border-collapse: collapse; }
    
    th {     font-size: 13px;     font-weight: normal;     padding: 8px;     background: #b9c9fe;
        border-top: 4px solid #aabcfe;    border-bottom: 1px solid #fff; color: #039; }
    
    td {    padding: 8px;     background: #e8edff;     border-bottom: 1px solid #fff;
        color: #669;    border-top: 1px solid transparent; }
    
    tr:hover td { background: #d0dafd; color: #339; } </style>';
    $html.= '<h2>Fecha: '.$fecha.'</h2>';
    
    foreach($rutas as $ruta){
        $html .= '<h3>Ruta: '. $ruta->nombre .'</h3>';
        
        $html .= '<table>';
        $html .= '<tr><th>Chofer</th><th>Vueltas</th></tr>';
        $id_empresa = 64;
        $paradas = App\Models\Paradas::where('id_ruta',$ruta->id)->count();
        $usuarios = App\Models\Usuario::where('id_empresa',$user->id_empresa)->where('id_rol','4')->get();

        foreach ($usuarios as $usuario) {
            

            $asistencias = App\Models\Asistencias::join('paradas', 'paradas.id','asistencias.id_parada')->join('usuarios', 'usuarios.id', 'asistencias.id_usuario')->where('usuarios.id_empresa',$user->id_empresa)->where('usuarios.id_rol','4')->where('paradas.id_ruta',$ruta->id)->where('id_usuario',$usuario->id)->whereRaw('asistencias.created_at >=? AND asistencias.created_at <= ?',[$fecha1,$fecha2])->count();

            if($asistencias>=1){
                $vueltas = $asistencias / $paradas;
                $html .= '<tr><td>' . $usuario->nombre . '</td><td>' . $vueltas . '</td></tr>';
                // $html .= '<h4> vueltas: '.$vueltas.'</h4>';
            }else{
                $html .= '<tr><td>' . $usuario->nombre . '</td><td>' . $asistencias . '</td></tr>';

                // $html .= '<h4> vueltas: '.$asistencias.'</h4>';

            }
   
        }
        $html .= '</table>';
        




    }

    // Crear instancia de Dompdf
    $dompdf = new Dompdf();
    
    // Cargar contenido HTML en Dompdf
    $dompdf->loadHtml($html);

    // Renderizar PDF
    $dompdf->render();

    // Devolver archivo PDF al cliente
    return response($dompdf->output(), 200)
        ->header('Content-Type', 'application/pdf');
})->middleware('jwt.auth');








