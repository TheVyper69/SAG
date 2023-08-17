<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sagapi.coiin.net/public/api/updateGerente',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('id' => $_POST['idUpdate'],'id_rol' => $_POST['rolU'],'nombre' => $_POST['nombreU'],'email' => $_POST['correoU'],'telefono' => $_POST['telefonoU'],'id_empresa' => $_POST['empresaU'],'password' => $_POST['passwordU'],'password_confirmation' => $_POST['password_confirmationU'],'estado' => $_POST['estado']),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;