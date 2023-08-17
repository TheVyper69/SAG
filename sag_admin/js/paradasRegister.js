

var formularioU = document.getElementById('editParada');

formularioU.addEventListener('submit', function(e){
    e.preventDefault();
    var formdata = new FormData(formularioU);

    $.ajax({
        url: "request/paradasU.php",
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
                    text: 'Pruebe en unos minutos por favor',
                })
            }else{
                $('#editParada')[0].reset();
                Swal.fire(":)","La ruta fue actualizada con exito","success");
                
                tabla() //actualiza la tabla 
                setTimeout(cerrarModal, 0);
            }

        }
    }); 
 
}); 

function cerrarModal() {
    $('#edit').modal('hide');
  }