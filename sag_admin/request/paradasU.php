<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sagapi.coiin.net/public/api/paradasUpdate',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('id' => $_POST['idU'],'id_ruta' => $_POST['rutaU'],'nombre' => $_POST['nombreU'],'coordenadas_x' => $_POST['coordsU']),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
?>