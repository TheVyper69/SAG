var formulario = document.getElementById('registroUser');
var pass1= document.getElementById('pass1');
var pass2= document.getElementById('pass2');




formulario.addEventListener('submit', function(e){
    e.preventDefault();
    var formdata = new FormData(formulario);
    var pass1= document.getElementById('pass1');
    var pass2= document.getElementById('pass2');
    const password1=pass1.value.trim();
    const password2=pass2.value.trim();

    if(password1 == password2){
        $.ajax({
            url: "request/usuarios.php",
            type: "POST",
            datatype: "html",
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                // console.log(respuesta);
    
                // respuesta = respuesta.trim();
                    
                if(respuesta == 1  ){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Pruebe con un correo diferente',
                    })
                }else{
                    $('#registroUser')[0].reset();
                    //$('#tablaCitas').load("gestor/tablacita.php");
                    Swal.fire(":)","El usuario fue registrado con éxito","success");
                    tabla()
                }
    
            }
        }); 
        
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Las contrsaeñas no coinciden',
        })
    }

    

    

})

var formularioU = document.getElementById('userU');
var pass1= document.getElementById('passU1');
var pass2= document.getElementById('passU2');


formularioU.addEventListener('submit', function(e){
    e.preventDefault();
    var formdata = new FormData(formularioU);
    const password1=pass1.value.trim();
    const password2=pass2.value.trim();

    if(password1 == password2){
        $.ajax({
            url: "request/gerenteU.php",
            type: "POST",
            datatype: "html",
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                // console.log(respuesta);
    
                // respuesta = respuesta.trim();
                    
                if(respuesta == 1  ){
                    $('#userU')[0].reset();
                    Swal.fire(":)","El usuario se actualizó correctamente","success");
                    
                    tabla()
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Pruebe con un correo diferente',
                    })
                }
    
            }
        }); 
        
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Las contrsaeñas no coinciden',
        })
    }

    

    

})



