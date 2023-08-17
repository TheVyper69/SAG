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
            echo $rol;
            if($data['id_rol']==2){
                
                // echo $_SESSION['token'];
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
        <title>SAG | INICIO</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed" background="Images\fondo3.jpg">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- LOGO-->
            <a class="navbar-brand ps-3" href="index.php">
                <img src="Images\SAG_1.png" style="font-size: 30px;"> </img>
            </a>
            <!-- ICONO MENU-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- BUSCADOR-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            </form>
            <!-- MENU DESPLEGABLE-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
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
                            <a class="nav-link" href="index_empresa.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Inicio
                            </a>
                            <a class="nav-link" href="admin_empresa.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                                Administradores
                            </a>
                            <a class="nav-link" href="empleados_empresa.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                                Empleados
                            </a>
                          
                            <a class="nav-link collapsed" href="rutas_empresa.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-location-dot"></i></div>
                                Rutas
                            </a>
                           
                            
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <!-- INICIO DE INTERFAZ-->
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">BIENVENIDO</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?php echo $data['nombre'];  ?></li>
                        </ol>
                        <div class="row">

                        <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body"><i class="fa-solid fa-user"></i> Administradores</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="admin_empresa.php">Ver mas</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body"><i class="fa-solid fa-users"></i> Empleados</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="empleados_empresa.php">Ver mas...</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body"><i class="fa-solid fa-location-dot"></i> Rutas</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="rutas_empresa.php">Ver mas</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            
                        <!-- BOTON REGISTRO-->

                                          </div>
</div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php
            }else{
                ?>
                    <script type="text/javascript">
                        alert("ACCESO DENEGADO");    
                        window.location.href="index.php";
                    </script>
                <?php
            }
        }