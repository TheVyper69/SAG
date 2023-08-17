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

            echo $rol;
            if($data['id_rol']==1){
                
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
    <link rel="shortcut icon" href="Images/a.png"> 
    <title>SAG | EMPRESAS</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">

    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
   
</head>

<body class="sb-nav-fixed" background="Images\fondo3.jpg">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- LOGO -->
        <a class="navbar-brand ps-3" href="index_spu.php">
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
                        <a class="nav-link" href="index_spu.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Inicio
                        </a>
                        <a class="nav-link" href="empresa_spu.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-building"></i></div>
                            Empresas
                        </a>

                        <a class="nav-link" href="gerentes_spu.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                            Gerentes
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

                        <div class="col-xl-6 col-md-6">
                            <h1 class="mt-4">REGISTRO EMPRESAS</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active"><?php echo $nombre; ?></li>
                            </ol>
                        </div>

                        

                        <div class="col-xl-3 col-md-6" ></br>
                    
                        <p align="right"> <button style="  text-align: right;" type="button" 
                        class="btn btn-primary" onclick="generarPDF()">
                        <i class="fa-solid fa-print"></i> IMPRIMIR

                        </button><br></br></p>
                        </div>  
                        <!-- BOTON REGISTRO-->
                        <div class="col-xl-3 col-md-6"></br>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                <i class="fa-solid fa-circle-plus"></i> AGREGAR EMPRESA
                            </button><br></br>
                            

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">REGISTRO EMPRESAS</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="row g-3" method="post" id="registrosEmpresa">
                                                <!-- <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text" id="inputGroupPrepend2"><i class="fa-solid fa-hashtag"></i></span>
                                            <input type="text"  minlength="2" maxlength="5" class="form-control" id="validationDefaultUsername"  placeholder="Folio" aria-describedby="inputGroupPrepend2" required>
                                        </div>
                                    </div> -->

                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                class="fa-solid fa-building"></i></span>
                                                        <input type="text" name="nombre" maxlength="60"
                                                            class="form-control" id="validationDefaultUsername"
                                                            placeholder="Nombre empresa"
                                                            aria-describedby="inputGroupPrepend2" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                class="fa-solid fa-phone"></i></span>
                                                        <input type="text" name="telefono" minlength="10" maxlength="17"
                                                            class="form-control" id="validationDefaultUsername"
                                                            placeholder="(+52)000 000 0000"
                                                            aria-describedby="inputGroupPrepend2" required>
                                                    </div>
                                                </div>

                                                <!-- <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text" id="inputGroupPrepend2"><i class="fa-solid fa-user"></i></span>
                                            <input type="text"  minlength="15" maxlength="60" class="form-control" id="validationDefaultUsername" placeholder="Nombre de usuario" aria-describedby="inputGroupPrepend2" required>
                                        </div>
                                    </div> -->

                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                class="fa-solid fa-envelope"></i></span>
                                                        <input type="email" name="correo" minlength="8" maxlength="50"
                                                            class="form-control" id="validationDefaultUsername"
                                                            placeholder="Correo" aria-describedby="inputGroupPrepend2"
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


                    <!-- TABLA DE EMPRESAS-->
                    <div id="tabla">
                    <?php
                        require("tables/empresas.php");
                    ?>
                    </div>
            </main>


            <!-- Modal Editar-->
            <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">EDITAR EMPRESA</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3" id="editEmpresa">
                                <div class="col-md-1">
                                    <div class="input-group">
                                        <!-- <span class="input-group-text" id="inputGroupPrepend2"><i
                                                class="fa-solid fa-hashtag"></i></span> -->
                                        <input type="hidden" name="idUpdate" minlength="2" maxlength="5" class="form-control"
                                            id="validationDefaultUsername" placeholder="Folio"
                                            aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                </div>

                                <div class="col-md-10">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                class="fa-solid fa-building"></i></span>
                                        <input type="text" maxlength="60" name="nombreUpdate" class="form-control"
                                            id="validationDefaultUsername" placeholder="Nombre empresa"
                                            aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                </div>
                                <div class="col-md-1">

                                    </div>

                                    <div class="col-md-1">

                                    </div>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                class="fa-solid fa-phone"></i></span>
                                        <input type="text" minlength="10" name="telefonoUpdate" maxlength="10" class="form-control"
                                            id="validationDefaultUsername" placeholder="(+52)000 000 0000"
                                            aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                </div>
                                <div class="col-md-1">

                                </div>
                                <div class="col-md-1">

                                </div>

                                <div class="col-md-10">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                class="fa-solid fa-user"></i></span>
                                        <input type="text" minlength="15" name="correoUpdate" maxlength="60" class="form-control"
                                            id="validationDefaultUsername" placeholder="correo"
                                            aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                </div>

                                <div class="col-md-1">

                                </div>

                                <!-- <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                class="fa-solid fa-lock"></i></span>
                                        <input type="password" minlength="8" maxlength="10" class="form-control"
                                            id="validationDefaultUsername" placeholder="Contraseña"
                                            aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                </div> -->

                                <div class="modal-footer">
                                    <div class="col-9"> </div>
                                    <div class="col-3">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="fa-solid fa-pen-to-square"></i> Editar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script> -->
    <!-- <script src="js/datatables-simple-demo.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
    <!-- <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script> -->
    <script src="js/empresas.js"></script>
    <script src="js/registroEmpresa.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

   <script>
   function generarPDF() {
    const divTabla = document.getElementById('tabla');
    html2canvas(divTabla).then(function(canvas) {
    const pdf = new jsPDF();

    // Obtener el ancho y alto de la página
    const pageSize = pdf.internal.pageSize;
    const pageWidth = pageSize.width;
    const pageHeight = pageSize.height;

    // Recortar la imagen
    const croppedCanvas = document.createElement('canvas');
    const croppedCtx = croppedCanvas.getContext('2d');
    croppedCanvas.width = 800; // ancho de la sección recortada
    croppedCanvas.height = 800; // altura de la sección recortada
    croppedCtx.drawImage(canvas, 0, 0, 800, 800, 0, 0, 800, 800);
    const imgData = croppedCanvas.toDataURL('image/png');
 

    // Agregar la imagen al PDF
    pdf.addImage(imgData, 'PNG', 10, 10, 190, 190); // agregar la imagen recortada con tamaño ajustado
    pdf.save('Empresas.pdf');
  });
}
   </script>
  


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