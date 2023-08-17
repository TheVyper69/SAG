<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sagapi.coiin.net/public/api/auth/login',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('email' => $_POST['correo'],'password' => $_POST['password']),
));
    $response = curl_exec($curl);
if (http_response_code() == 200) {
    // La solicitud fue exitosa
    
    // Devuelve la respuesta en formato JSON como un array asociativo
    $data = json_decode($response, true); 
    session_start();

    $_SESSION['token'] = $data['access_token'];

    $token=$_SESSION['token'];

    
    $url = 'https://sagapi.coiin.net/public/api/rolUser'; 
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Authorization: Bearer ' . $token // Incluye el token en el encabezado de la solicitud
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response1 = curl_exec($ch);
    // echo $response1;
    
    $data1 = json_decode($response1, true);
   
    if(http_response_code() == 200){
        $rol = $data1['id_rol'];
        $id= $data1['id'];
        echo $rol;
        
    }else{
      echo "algo salio mal";
    }
}else{
        echo "verifique sus datos";
    }
curl_close($ch);