const editRuta = (id) =>{
    fetch("https://sagapi.coiin.net/public/api/obtenerRuta?id="+id)
    .then(response => response.json())
    .then(empresas => {

        var i = 0

        for (i; i < empresas.length; i++){
            document.getElementsByName("idU")[0].value = empresas[i].id;
           
            document.getElementsByName("nombreU")[0].value = empresas[i].nombre;
            

            

        }
        
    })
    .catch(error => console.log('error', error));   
}
const eliminarRuta = (id) =>{
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
            fetch("https://sagapi.coiin.net/public/api/rutasDelete?id="+id, requestOptions)
            .then(response => response.text())
            .then(empresas => {
                // console.log(empresas)
                if(empresas==1){
                    Swal.fire(
                        'Eliminado!',
                        'La ruta fue eliminada.',
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
      })}