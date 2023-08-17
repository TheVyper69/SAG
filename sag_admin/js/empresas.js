const editEmpresa = (id) =>{
    fetch("https://sagapi.coiin.net/public/api/obtenerEmpresa?id="+id)
    .then(response => response.json())
    .then(empresas => {

        var i = 0

        for (i; i < empresas.length; i++){
            document.getElementsByName("idUpdate")[0].value = empresas[i].id;
            document.getElementsByName("nombreUpdate")[0].value = empresas[i].nombre;
            document.getElementsByName("telefonoUpdate")[0].value = empresas[i].telefono;
            document.getElementsByName("correoUpdate")[0].value = empresas[i].correo;

        }
        
    })
    .catch(error => console.log('error', error));   
}

const eliminarEmpresa = (id) =>{
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
            fetch("https://sagapi.coiin.net/public/api/empresaDelete?id="+id, requestOptions)
            .then(response => response.text())
            .then(empresas => {
                // console.log(empresas)
                if(empresas==1){
                    Swal.fire(
                        'Eliminado!',
                        'La empresa fue eliminada.',
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
            // .catch(error => );

            

           
        }
      })

    console.log(id);
}