<?php
 $curl = curl_init();

 curl_setopt_array($curl, array(
   CURLOPT_URL => 'https://sagapi.coiin.net/public/api/correoUser',
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => '',
   CURLOPT_MAXREDIRS => 10,
   CURLOPT_TIMEOUT => 0,
   CURLOPT_FOLLOWLOCATION => true,
   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
   CURLOPT_CUSTOMREQUEST => 'POST',
   CURLOPT_POSTFIELDS => array('correo' => $_POST['correo']),
 ));

 $response = curl_exec($curl);

 curl_close($curl);

 
 echo $response;



if($response == 0){
  
  $curl = curl_init();

  curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sagapi.coiin.net/public/api/auth/register',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('id_rol' => $_POST['rol'],'nombre' => $_POST['nombre'],'email' => $_POST['correo'],'telefono' => $_POST['telefono'],'id_empresa' => $_POST['empresa'],'ruta' => $_POST['ruta'],'password' => $_POST['password'],'password_confirmation' => $_POST['password_confirmation']),
  ));

  $result = curl_exec($curl);

  curl_close($curl);
  
  //echo $result; 
}






