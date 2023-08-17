var formulario = document.getElementById('registroRuta');


formulario.addEventListener('submit', function(e){
    e.preventDefault();
    var formdata = new FormData(formulario);

    $.ajax({
        url: "request/rutas.php",
        type: "POST",
        datatype: "html",
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            console.log(respuesta);

            // respuesta = respuesta.trim();
                
            if(respuesta == 1  ){
                
                Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Pruebe en unos minutos',
                        })

            }else{
                $('#registroRuta')[0].reset();
                Swal.fire(":)","La ruta fue registrada con exito","success");
                
                tabla()
            }

        }
    }); 
});
var formularioU = document.getElementById('editRuta');

formularioU.addEventListener('submit', function(e){
    e.preventDefault();
    var formdata = new FormData(formularioU);

    $.ajax({
        url: "request/rutasU.php",
        type: "POST",
        datatype: "html",
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            console.log(respuesta);

            // respuesta = respuesta.trim();
                
            if(respuesta == 1  ){
                $('#editRuta')[0].reset();
                Swal.fire(":)","La ruta fue actualizada con exito","success");
                
                tabla() //actualiza la tabla 
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Pruebe en unos minutos por favor',
                })
            }

        }
    }); 
 
}); 