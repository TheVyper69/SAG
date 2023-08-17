const editUsuario = (id) =>{
    fetch("https://sagapi.coiin.net/public/api/obtenerUser?id="+id)
    .then(response => response.json())
    .then(empresas => {

        var i = 0

        for (i; i < empresas.length; i++){
            document.getElementsByName("idUpdate")[0].value = empresas[i].id;
            document.getElementsByName("rolU")[0].value = empresas[i].id_rol;
            document.getElementsByName("nombreU")[0].value = empresas[i].nombre;
            document.getElementsByName("telefonoU")[0].value = empresas[i].telefono;
            document.getElementsByName("correoU")[0].value = empresas[i].email;
            document.getElementsByName("empresaU")[0].value = empresas[i].id_empresa;

            

        }
        
    })
    .catch(error => console.log('error', error));   
}
const eliminarGerente = (id) =>{
    Swal.fire({
        title: '¿Seguro que lo quieres borrar?',
        text: "Esta acción no se podra revertir",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'SI'
      }).then((result) => {
        if (result.isConfirmed) {
            var requestOptions = {
                method: 'DELETE',
                redirect: 'follow'
              };
            fetch("https://sagapi.coiin.net/public/api/eliminarUser?id="+id, requestOptions)
            .then(response => response.text())
            .then(empresas => {
                // console.log(empresas)
                if(empresas==1){
                    Swal.fire(
                        'Eliminado!',
                        'El usuario fue eliminado.',
                        'success'
                    )
                    tabla()
                }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'A ocurrido un error pruebe en unos minutos',
                        })
                    }
                }
                )
                .catch(error => console.log('error', error));  
        }
      })

    // console.log(id);
}