var formulario = document.getElementById('registrosEmpresa');
document.getElementById('dataTable');

formulario.addEventListener('submit', function(e){
    e.preventDefault();
    var formdata = new FormData(formulario);

    $.ajax({
        url: "request/empresas.php",
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
                    text: 'Pruebe con un correo diferente',
                })


            }else{
                $('#registrosEmpresa')[0].reset();
                Swal.fire(":)","La empresa fue registrada con exito","success");
                
                tabla()
            }

        }
    }); 
})

var formularioU = document.getElementById('editEmpresa');

formularioU.addEventListener('submit', function(e){
    e.preventDefault();
    var formdata = new FormData(formularioU);

    $.ajax({
        url: "request/empresaU.php",
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
                $('#editEmpresa')[0].reset();
                Swal.fire(":)","La empresa fue actualizada con exito","success");
                
                tabla() //actualiza la tabla 
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Pruebe con un correo diferente',
                })
            }

        }
    }); 
 
}); 