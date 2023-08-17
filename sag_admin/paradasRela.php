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
    <title>SAG | RUTAS</title>
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
                            <h1 class="mt-4">REGISTRO PARADA</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active"><?php echo $nombre; ?></li>
                            </ol>
                        </div>
                        <!-- BOTON REGISTRO-->
                        <div class="col-xl-3 col-md-6"></br>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#paradaRelaM">
                                <i class="fa-solid fa-circle-plus"></i> AGREGAR
                            </button><br></br>

                            <!-- Modal -->
                            <div class="modal fade" id="paradaRelaM" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">RELACIONAR PARADAS</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="row g-3" id="paradaRela">
                                                <div class="col-md-12">
                                                    <label for="select1">Parada principal</label>

                                                    <div class="input-group">

                                                        <select class="form-select" id="select1">
                                                            <option selected>Selecciona una parada</option>
                                                            <script>
                                                                var token = "<?php  echo $_SESSION['token']; ?>"
                                                                var requestOptions = {
                                                                    method: 'GET',
                                                                    redirect: 'follow',
                                                                    headers: {
                                                                        'Authorization': 'Bearer ' + token
                                                                    }

                                                                };
                                                                fetch('https://sagapi.coiin.net/public/api/paradasEmpresa',
                                                                        requestOptions)
                                                                    .then(response => response.json())
                                                                    .then(data => {
                                                                        // console.log(data)

                                                                        // Aquí manejas los datos recibidos de la API
                                                                        let select = document.getElementById(
                                                                            'select1');
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
                                                <div class="col-md-12">
                                                    <label for="select2">Parada anterior</label>

                                                    <div class="input-group">
                                                        <select class="form-select" id="select2">
                                                            <option selected>Selecciona una parada</option>
                                                            <script>
                                                                var token = "<?php  echo $_SESSION['token']; ?>"
                                                                var requestOptions = {
                                                                    method: 'GET',
                                                                    redirect: 'follow',
                                                                    headers: {
                                                                        'Authorization': 'Bearer ' + token
                                                                    }

                                                                };
                                                                fetch('https://sagapi.coiin.net/public/api/paradasEmpresa',
                                                                        requestOptions)
                                                                    .then(response => response.json())
                                                                    .then(data => {
                                                                        // console.log(data)

                                                                        // Aquí manejas los datos recibidos de la API
                                                                        let select = document.getElementById(
                                                                            'select2');
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
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <input class="form-control" type="number" name="tiempo"
                                                            id="tiempo" min="1" max="99"
                                                            placeholder="Tiempo entre paradas en minutos">
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
                            require ("tables/paradas_rela.php")
                        ?>
            </main>


            <!-- Modal Editar-->
            <div class="modal fade" id="editParada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">EDITAR</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3" id="editParadarela">
                                <div class="col-md-0">
                                    <div class="input-group">
                                        <!-- <span class="input-group-text" id="inputGroupPrepend2"><i
                                                                    class="fa-solid fa-hashtag"></i></span> -->
                                        <input type="hidden" name="idUpdate" minlength="2" maxlength="5"
                                            class="form-control" id="idU" placeholder="Folio"
                                            aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="select1">Parada principal</label>

                                    <div class="input-group">

                                        <select class="form-select" name="select1U" id="select1U">
                                            <option selected>Selecciona una parada</option>
                                            <script>
                                                var token = "<?php  echo $_SESSION['token']; ?>"
                                                var requestOptions = {
                                                    method: 'GET',
                                                    redirect: 'follow',
                                                    headers: {
                                                        'Authorization': 'Bearer ' + token
                                                    }

                                                };
                                                fetch('https://sagapi.coiin.net/public/api/paradasEmpresa',
                                                        requestOptions)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        // console.log(data)

                                                        // Aquí manejas los datos recibidos de la API
                                                        let select = document.getElementById(
                                                            'select1U');
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
                                <div class="col-md-12">
                                    <label for="select2">Parada anterior</label>

                                    <div class="input-group">
                                        <select class="form-select" name="select2U" id="select2U">
                                            <option selected>Selecciona una parada</option>
                                            <script>
                                                var token = "<?php  echo $_SESSION['token']; ?>"
                                                var requestOptions = {
                                                    method: 'GET',
                                                    redirect: 'follow',
                                                    headers: {
                                                        'Authorization': 'Bearer ' + token
                                                    }

                                                };
                                                fetch('https://sagapi.coiin.net/public/api/paradasEmpresa',
                                                        requestOptions)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        // console.log(data)

                                                        // Aquí manejas los datos recibidos de la API
                                                        let select = document.getElementById(
                                                            'select2U');
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
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input class="form-control" type="number" name="tiempoU" id="tiempoU" min="1"
                                            max="99" placeholder="Tiempo entre paradas en minutos">
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
    <script src="js/paradasRela.js"></script>
    <script>
        var formularioL = document.querySelector('#paradaRela');
        formularioL.addEventListener('submit', function (event) {
            event.preventDefault();
            // const button = document.querySelector('#pdf');
            const paradaP = formularioL.querySelector('#select1').value;
            const paradaS = formularioL.querySelector('#select2').value;
            const tiempo = document.getElementById('tiempo').value;



            if (paradaP == paradaS) {
                Swal.fire(
                    'SAG!',
                    'No pueden ser relacionadas las mismas paradas',
                    'error'
                )
            } else {
                var formdata = new FormData();
                formdata.append("id_parada", paradaP);
                formdata.append("id_parada_anterior", paradaS);
                formdata.append("tiempo", tiempo);

                var requestOptions = {
                    method: 'POST',
                    body: formdata,
                    redirect: 'follow'
                };

                fetch("https://sagapi.coiin.net/public/api/registroParada", requestOptions)
                    .then(response => response.text())
                    .then(result => {
                        if (result == 0) {
                            $('#paradaRela')[0].reset();
                            Swal.fire(
                                'SAG!',
                                'El REGISTRO FUE UN EXITO',
                                'success'
                            )
                            tabla()
                            setTimeout(cerrarModal1, 0);

                        } else {
                            Swal.fire(
                                'SAG!',
                                'A ocurrido un error',
                                'error'
                            )
                        }

                    })
                    .catch(error => console.log('error', error));
            }

            function cerrarModal1() {
                $('#paradaRelaM').modal('hide');
            }
        });
        var formularioL = document.querySelector('#editParadarela');
        formularioL.addEventListener('submit', function (event) {
            event.preventDefault();
            // const button = document.querySelector('#pdf');
            const id = formularioL.querySelector('#idU').value;
            const paradaP = formularioL.querySelector('#select1U').value;
            const paradaS = formularioL.querySelector('#select2U').value;
            const tiempo = document.getElementById('tiempoU').value;



            if (paradaP == paradaS) {
                Swal.fire(
                    'SAG!',
                    'No pueden ser relacionadas las mismas paradas',
                    'error'
                )
            } else {
                var formdata = new FormData();
                formdata.append("id", id);
                formdata.append("id_parada", paradaP);
                formdata.append("id_parada_anterior", paradaS);
                formdata.append("tiempo", tiempo);

                var requestOptions = {
                    method: 'POST',
                    body: formdata,
                    redirect: 'follow'
                };

                fetch("https://sagapi.coiin.net/public/api/paradasrelaUpdate", requestOptions)
                    .then(response => response.text())
                    .then(result => {
                        if (result == 0) {
                            $('#editParadarela')[0].reset();
                            Swal.fire(
                                'SAG!',
                                'SE HA ACTUALIZADO CON EXITO',
                                'success'
                            )
                            tabla()
                            setTimeout(cerrarModal2, 0);

                        } else {
                            Swal.fire(
                                'SAG!',
                                'A ocurrido un error',
                                'error'
                            )
                        }

                    })
                    .catch(error => console.log('error', error));
            }

            function cerrarModal2() {
                $('#editParada').modal('hide');
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