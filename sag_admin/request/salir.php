<?php
    session_start();

    $url = 'https://sagapi.coiin.net/public/api/auth/logout'; 
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $_SESSION['token'] // Incluye el token en el encabezado de la solicitud
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response1 = curl_exec($ch);
    
    if(http_response_code() === 200){
        session_destroy();
        header('location:../index.php');
    }


?>