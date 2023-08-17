<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="shortcut icon" href="images/a.png"> 
        <title>RECUPERAR CONTRASEÑA</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body style="background-color:#81beea;">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Recuperar contraseña</h3></div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">Ingrese su dirección de correo electrónico y le enviaremos un enlace para restablecer su contraseña.</div>
                                        <form id="formEmail">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="correo" placeholder="name@example.com" minlength="10" maxlength="60" required/>
                                                <label for="inputEmail">Correo electronico</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="index.php">Atras</a>
                                                <button class="btn btn-primary"type="submit">Enviar</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; SAG 2023</div>
                         
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>

            var formularioL = document.getElementById('formEmail');
            formularioL.addEventListener('submit', function(e){
                e.preventDefault();
                 var formdata = new FormData(formularioL);
                  $.ajax({

                    url: "request/correo.php",
                    type: "POST",
                    datatype: "html",
                    data: formdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        console.log(respuesta);
                        
                        if(respuesta==1){
                            window.location = "cambioPass.php";
                        }else if(respuesta==2){
                            Swal.fire({
                                icon: 'error',
                                title: '>:|',
                                text: 'El correo no esta registrado',
                            });
                        }
                    }
                }); 
            })
        </script>
    </body>
</html>
