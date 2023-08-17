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
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Recuperar contraseña</h3>
                                </div>
                                <div class="card-body">
                                    <div class="small mb-3 text-muted">En el correo que introdujo debio de haber
                                        recibido un codigo</div>
                                    <form id="formpass">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputext" type="text" name="codigo"
                                                placeholder="Código" minlength="6" maxlength="6" required />
                                            <label for="inputEmail">Código</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputpass1" type="password" name="password1"
                                            placeholder="Introduzca su nueva contraseña" minlength="8" maxlength="60" required />
                                            <label for="inputpass1">Introduzca su nueva contraseña</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputpass2" type="password" name="password2"
                                                placeholder="Confirma tu contraseña" minlength="8" maxlength="60" required />
                                            <label for="inputpass2">Confirma tu contraseña</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="index.php">Atras</a>
                                            <button class="btn btn-primary" type="submit">Enviar</button>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var formularioL = document.getElementById('formpass');
        var pass1 = document.getElementById('inputpass1');
        var pass2 = document.getElementById('inputpass2');
        formularioL.addEventListener('submit', function (e) {
            e.preventDefault();
            var formdata = new FormData(formularioL);
            const password1 = pass1.value.trim();
            const password2 = pass2.value.trim();
            if (password1 == password2) {
                $.ajax({

                    url: "request/pass.php",
                    type: "POST",
                    datatype: "html",
                    data: formdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        console.log(respuesta);

                        if (respuesta == 1) {

                            Swal.fire({
                                title: 'La contraseña se a cambiado con exito',                          
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Entendido'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = "index.php";
                                }
                            })
                            
                        } else if (respuesta == 2) {
                            Swal.fire({
                                icon: 'error',
                                title: '>:|',
                                text: 'El codigo no es valido',
                            });
                        }
                    }
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: '>:|',
                    text: 'Las contraseñas no coinciden',
                });
            }

        })
    </script>
</body>

</html>