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
    <title>SAG | EMPLEADOS</title>
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

                        <div class="col-xl-6 col-md-6">
                            <h1 class="mt-4">REGISTRO EMPLEADOS</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active"><?php echo $nombre; ?></li>
                            </ol>
                        </div>

                        <!--BOTON PDF-->

                        <div class="col-xl-3 col-md-6"></br>

                            <p align="right"> <button id="pdf" style="  text-align: right;" type="button"
                                    class="btn btn-primary">
                                    <i class="fa-solid fa-print"></i> IMPRIMIR
                                </button><br></br></p>
                        </div>

                        <!-- BOTON REGISTRO-->
                        <div class="col-xl-3 col-md-6"></br>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                <i class="fa-solid fa-circle-plus"></i> AGREGAR EMPLEADO
                            </button><br></br>

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">REGISTRO EMPLEADO</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="row g-3" id="registroUser">
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                class="fa-solid fa-hashtag"></i></span>
                                                        <select class="form-select" name="rol" id="id_rol">
                                                            <option selected>Rol</option>
                                                            <script>
                                                                fetch('https://sagapi.coiin.net/public/api/allRoles')
                                                                    .then(response => response.json())
                                                                    .then(data => {
                                                                        // console.log(data)

                                                                        const datos = [
                                                                            data[3],
                                                                            data[4]

                                                                        ]

                                                                        // Aquí manejas los datos recibidos de la API
                                                                        let select = document.getElementById(
                                                                            'id_rol');
                                                                        for (let item of datos) {
                                                                            let option = document.createElement(
                                                                                'option');
                                                                            option.value = item.id;
                                                                            option.text = item.nombre;
                                                                            select.add(option);
                                                                        }
                                                                    })
                                                                    .catch(error => {
                                                                        console.error(
                                                                            'Hubo un error al obtener los datos: ',
                                                                            error);
                                                                    });
                                                            </script>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                class="fa-solid fa-user-pen"></i></span>
                                                        <input type="text" name="nombre" maxlength="60"
                                                            class="form-control" id="validationDefaultUsername"
                                                            placeholder="Nombre completo"
                                                            aria-describedby="inputGroupPrepend2" required>
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                class="fa-sharp fa-solid fa-at"></i></span>
                                                        <input type="email" name="correo" minlength="10" maxlength="60"
                                                            class="form-control" id="validationDefaultUsername"
                                                            placeholder="Correo" aria-describedby="inputGroupPrepend2"
                                                            required>
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                class="fa-solid fa-phone"></i></span>
                                                        <input type="text" name="telefono" minlength="" maxlength="10"
                                                            class="form-control" id="validationDefaultUsername"
                                                            placeholder="Telefono" aria-describedby="inputGroupPrepend2"
                                                            required>
                                                    </div>
                                                </div>


                                                <!-- <div class="col-md-6">
                                                            <div class="input-group">
                                                                <span class="input-group-text" id="inputGroupPrepend2"><i class="fa-solid fa-user"></i></span>
                                                                <input type="text" name="ruta"  minlength="" maxlength="10" class="form-control" id="validationDefaultUsername" placeholder="Ruta (solo choferes)" aria-describedby="inputGroupPrepend2" >
                                                            </div>
                                                        </div> -->

                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                class="fa-solid fa-lock"></i></span>
                                                        <input type="password" name="password" minlength="8"
                                                            maxlength="10" class="form-control" id="pass1"
                                                            placeholder="Contraseña"
                                                            aria-describedby="inputGroupPrepend2" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                class="fa-solid fa-lock"></i></span>
                                                        <input type="password" name="password_confirmation"
                                                            minlength="8" maxlength="10" class="form-control" id="pass2"
                                                            placeholder="Confirme su contraseña"
                                                            aria-describedby="inputGroupPrepend2" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-0">
                                                    <div class="input-group">
                                                        <!-- <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                                    class="fa-solid fa-briefcase"></i></span> -->
                                                        <select hidden class="form-select" name="empresa"
                                                            id="id_empresa">

                                                            <script>
                                                                var token = "<?php  echo $_SESSION['token']; ?>"
                                                                var requestOptions = {
                                                                    method: 'GET',
                                                                    redirect: 'follow',
                                                                    headers: {
                                                                        'Authorization': 'Bearer ' + token
                                                                    }

                                                                };
                                                                fetch('https://sagapi.coiin.net/public/api/empresaUser',
                                                                        requestOptions)
                                                                    .then(response => response.json())
                                                                    .then(data => {
                                                                        // console.log(data)

                                                                        // Aquí manejas los datos recibidos de la API
                                                                        let select = document.getElementById(
                                                                            'id_empresa');
                                                                        for (let item of data) {
                                                                            let option = document.createElement(
                                                                                'option');
                                                                            option.value = item.id;
                                                                            option.text = item.nombre;
                                                                            select.add(option);
                                                                        }
                                                                    })
                                                                    .catch(error => {
                                                                        console.error(
                                                                            'Hubo un error al obtener los datos: ',
                                                                            error);
                                                                    });
                                                            </script>
                                                        </select>
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
                    <?php

                            require("tables/empleados.php");

                        ?>
            </main>


            <!-- Modal Editar-->
            <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">EDITAR EMPLEADO</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3" id="userU">
                                <div class="col-md-0">
                                    <div class="input-group">
                                        <!-- <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                    class="fa-solid fa-hashtag"></i></span> -->
                                        <input type="hidden" name="idUpdate" minlength="2" maxlength="5"
                                            class="form-control" id="validationDefaultUsername" placeholder="Folio"
                                            aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                class="fa-solid fa-hashtag"></i></span>
                                        <select class="form-select" name="rolU" id="id_rolu">
                                            <option selected>Rol</option>
                                            <script>
                                                fetch('https://sagapi.coiin.net/public/api/allRoles')
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        // console.log(data)

                                                        const datos = [
                                                            data[3],
                                                            data[4]


                                                        ]

                                                        // Aquí manejas los datos recibidos de la API
                                                        let select = document.getElementById(
                                                            'id_rolu');
                                                        for (let item of datos) {
                                                            let option = document.createElement(
                                                                'option');
                                                            option.value = item.id;
                                                            option.text = item.nombre;
                                                            select.add(option);
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error(
                                                            'Hubo un error al obtener los datos: ',
                                                            error);
                                                    });
                                            </script>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                class="fa-solid fa-user-pen"></i></span>
                                        <input type="text" name="nombreU" maxlength="60" class="form-control"
                                            id="validationDefaultUsername" placeholder="Nombre completo"
                                            aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                class="fa-sharp fa-solid fa-at"></i></span>
                                        <input type="email" name="correoU" minlength="10" maxlength="60"
                                            class="form-control" id="validationDefaultUsername" placeholder="Correo"
                                            aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                class="fa-solid fa-phone"></i></span>
                                        <input type="text" name="telefonoU" minlength="" maxlength="10"
                                            class="form-control" id="validationDefaultUsername" placeholder="Telefono"
                                            aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                </div>


                                <!-- <div class="col-md-6">
                                                            <div class="input-group">
                                                                <span class="input-group-text" id="inputGroupPrepend2"><i class="fa-solid fa-user"></i></span>
                                                                <input type="text" name="ruta"  minlength="" maxlength="10" class="form-control" id="validationDefaultUsername" placeholder="Ruta (solo choferes)" aria-describedby="inputGroupPrepend2" >
                                                            </div>
                                                        </div> -->

                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                class="fa-solid fa-lock"></i></span>
                                        <input type="password" name="passwordU" minlength="8" maxlength="10"
                                            class="form-control" id="passU1" placeholder="Contraseña"
                                            aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend2"><i
                                                class="fa-solid fa-lock"></i></span>
                                        <input type="password" name="password_confirmationU" minlength="8"
                                            maxlength="10" class="form-control" id="passU2"
                                            placeholder="Confirme su contraseña" aria-describedby="inputGroupPrepend2"
                                            required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroupPrepend2"><i
                                            class="fa-solid fa-briefcase"></i></span>
                                    <select class="form-select" name="estado" id="estado">
                                        <option selected>Activo</option>
                                        <option Value="s">Si</option>
                                        <option Value="n">No</option>


                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <!-- <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                                    class="fa-solid fa-briefcase"></i></span> -->
                                        <select hidden class="form-select" name="empresaU" id="id_empresau">
                                            <option selected>Empresa</option>
                                            <script>
                                                fetch('https://sagapi.coiin.net/public/api/allEmpresas')
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        // console.log(data)

                                                        // Aquí manejas los datos recibidos de la API
                                                        let select = document.getElementById(
                                                            'id_empresau');
                                                        for (let item of data) {
                                                            let option = document.createElement(
                                                                'option');
                                                            option.value = item.id;
                                                            option.text = item.nombre;
                                                            select.add(option);
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error(
                                                            'Hubo un error al obtener los datos: ',
                                                            error);
                                                    });
                                            </script>
                                        </select>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <div class="col-9"> </div>
                                    <div class="col-3">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="fa-solid fa-circle-plus"></i> Editar</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="js/usuarioRegister.js"></script>
    <script src="js/gerentes.js"></script>

    <script>
        const button = document.querySelector('#pdf');

        button.addEventListener('click', function () {
            token = '<?php echo $_SESSION['token']; ?>'
            fetch('https://sagapi.coiin.net/public/api/pdf', {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token // Token JWT del usuario autenticado
                    }
                })
                .then(response => response.blob())
                .then(blob => {
                    // Crear objeto URL para descargar el archivo
                    const url = URL.createObjectURL(blob);

                    // Crear enlace de descarga
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'Empleados.pdf';

                    // Agregar enlace de descarga al DOM y hacer clic en él
                    document.body.appendChild(a);
                    a.click();

                    // Eliminar objeto URL y enlace de descarga del DOM
                    a.remove();
                    URL.revokeObjectURL(url);
                })
                .catch(error => console.error(error));
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