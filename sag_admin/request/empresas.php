<?php


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sagapi.coiin.net/public/api/correoEmpresa',
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

if($response == 0 ){
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://sagapi.coiin.net/public/api/empresaRegister',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('nombre' => $_POST['nombre'],'telefono' =>  $_POST['telefono'] ,'correo' => $_POST['correo'] ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  // return $response;
}



