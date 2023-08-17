

<div class="card mb-4">
                        <div class="card-header">
                            <i class="fa-solid fa-building"></i>
                            Rutas
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table">
                                    <thead>
                                        <tr>
                                           
                                            <th>NOMBRE</th>
                                            

                                            <th>...</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                      
                                    </tfoot>
                                    <tbody>
                                        
                                        

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <script type ="text/javascript">
    window.onload = function()  {
        tabla()
  
    }
    function tabla(){

    var token = " <?php  echo $_SESSION['token']; ?>"
    var requestOptions = {
                    method: 'GET',
                    redirect: 'follow',
                    headers:{
                        'Authorization': 'Bearer ' + token
                    }

                };

                fetch('https://sagapi.coiin.net/public/api/rutasEmpresa',requestOptions)
                    .then(response => response.json())
                    .then(empresas => {
                        let body = ``
                        // console.log(empresas)
                        var i = 0
                        for (i; i < empresas.length; i++) {
                            body += `
                            <tr>
                                
                                <td>${empresas[i].nombre}</td>
                                
                                
                                <td>
                                    <div class="d-grid gap-2 d-md-block">
                                        <button class="btn btn-success" type="button" data-bs-toggle="modal"onclick="editRuta(${empresas[i].id})" data-bs-target="#edit">
                                            <i class="fa-solid fa-pen-to-square"></i> 
                                        </button>

                                        <button class="btn btn-danger"  type="button" onclick="eliminarRuta(${empresas[i].id})">
                                            <i class="fa-solid fa-trash-can"></i> 
                                        </button>
                                    </div> 
                                </td>
                            </tr>`
                            // console.log(body)
                        }

                        document.querySelector('#dataTable tbody').innerHTML = body
                    })
}
</script>