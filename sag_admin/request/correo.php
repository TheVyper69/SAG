<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sagapi.coiin.net/public/api/codigoValidacion',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('email' => $_POST['correo']),
));

$response = curl_exec($curl);

$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ($httpCode == 200){
    echo ('1');
}elseif($httpCode == 401){
    echo ('2');
}

curl_close($curl);

