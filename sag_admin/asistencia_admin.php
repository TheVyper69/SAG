<?php
    session_start();

        $url = 'https://sagapi.coiin.net/public/api/rolUser'; 
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $_SESSION['token'] // Incluye el token en el encabezado de la solicitud
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response1 = curl_exec($ch);
        
        if(http_response_code() === 200){
            $data = json_decode($response1, true);

            $rol = $data['id_rol'];
            $nombre=$data['nombre'];
            if($rol==3){
                
                ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="images/a.png">
    <title>SAG | ASISTENCIAS</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed" background="Images\fondo3.jpg">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- LOGO -->
        <a class="navbar-brand ps-3" href="index.php">
            <img src="Images\SAG_1.png" style="font-size: 30px;"> </img>
        </a>
        <!-- BOTON MENU-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- BUSCADOR-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </form>
        <!-- MENU DESPLEGABLE-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="request/salir.php">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav"><br>
                        <a class="nav-link" href="index_admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Inicio
                        </a>
                        <a class="nav-link" href="empleados_admin.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                            Empleados
                        </a>

                        <a class="nav-link collapsed" href="paradas_admin.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-location-dot"></i></div>
                            paradas
                        </a>
                        <a class="nav-link collapsed" href="paradasRela.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-location-dot"></i></div>
                            Paradas relacionadas
                        </a>

                        <a class="nav-link collapsed" href="asistencia_admin.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-check-to-slot"></i></div>
                            Asistencias
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <!-- INICIO DE INTERFAZ-->
                <div class="container-fluid px-4">


                    <div class="row">

                        <div class="col-xl-9 col-md-6">
                            <h1 class="mt-4">CONTROL DE ASISTENCÍAS</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active"><?php echo $nombre; ?></li>
                            </ol>
                        </div>
                       
                        <div class="col-xl-3 col-md-6"></br>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                <i class="fa-solid fa-download"></i> Descarga registro
                            </button><br></br>

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Descarga registro de
                                                vueltas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="row g-3" id="pdf">
                                                <div class="col-md-12">
                                                    <label for="fechaI">Fecha de inicio</label>

                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                class="fa-solid fa-map-location-dot"></i></span>
                                                        <input type="date" class="form-control" id="fechaI"
                                                            name="fechaI" aria-describedby="inputGroupPrepend2"
                                                            required>

                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="fechaF">Fecha de fin</label>

                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                class="fa-solid fa-map-location-dot"></i></span>
                                                        <input type="date" class="form-control" id="fechaF"
                                                            name="fechaF" aria-describedby="inputGroupPrepend2"
                                                            required>

                                                    </div>
                                                </div>







                                                <div class="modal-footer">
                                                    <div class="col-9"> </div>
                                                    <div class="col-3">
                                                        <button class="btn btn-primary" type="submit"><i
                                                                class="fa-solid fa-circle-plus"></i> Agregar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA-->

                    <?php
                                    require("tables/asistencias.php");
                                ?>

            </main>

        </div>
    </div>

    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; SAG 2023</div>
                <div>
                    <a href="#">Politicas de privacidad</a>
                    &middot;
                    <a href="#">Terminos y condiciones</a>
                </div>
            </div>
        </div>
    </footer>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>


    <script>
        var formularioL = document.querySelector('#pdf');


        formularioL.addEventListener('submit', function (event) {
            event.preventDefault();
            // const button = document.querySelector('#pdf');
            const fechaI = formularioL.querySelector('#fechaI').value;
            const fechaF = formularioL.querySelector('#fechaF').value;

            if(fechaI == fechaF){
                const data = {
                fechaI: fechaI
            };


            token = '<?php echo $_SESSION['token']; ?>'
            fetch('https://sagapi.coiin.net/public/api/asistenciaPDF', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token // Token JWT del usuario autenticado
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.blob())
                .then(blob => {
                    // Crear objeto URL para descargar el archivo
                    const url = URL.createObjectURL(blob);

                    // Crear enlace de descarga
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'Asistencias.pdf';

                    // Agregar enlace de descarga al DOM y hacer clic en él
                    document.body.appendChild(a);
                    a.click();

                    // Eliminar objeto URL y enlace de descarga del DOM
                    a.remove();
                    URL.revokeObjectURL(url);
                })
                .catch(error => console.error(error));
            }else{
                const data = {
                fechaI: fechaI,
                fechaF: fechaF
            };


            token = '<?php echo $_SESSION['token']; ?>'
            fetch('https://sagapi.coiin.net/public/api/asistenciasPdf', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token // Token JWT del usuario autenticado
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.blob())
                .then(blob => {
                    // Crear objeto URL para descargar el archivo
                    const url = URL.createObjectURL(blob);

                    // Crear enlace de descarga
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'Asistencias.pdf';

                    // Agregar enlace de descarga al DOM y hacer clic en él
                    document.body.appendChild(a);
                    a.click();

                    // Eliminar objeto URL y enlace de descarga del DOM
                    a.remove();
                    URL.revokeObjectURL(url);
                })
                .catch(error => console.error(error));
            }

            

               
        });
    </script>


</body>

</html>
<?php
            }else{
                ?>
<script type="text/javascript">
    alert("ACCESO DENEGADO");
    window.location.href = "index.php";
</script>
<?php
    }
}
?>