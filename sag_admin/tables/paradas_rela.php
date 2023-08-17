

<div class="card mb-4">
                        <div class="card-header">
                            <i class="fa-solid fa-building"></i>
                            Paradas relacionadas
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Parada principal</th>
                                            <th>Parada anterior</th>
                                            <th>Tiempo</th>

                                            

                                            <th>...</th>

                                        </tr>
                                    </thead>
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
                    method: 'POST',
                    redirect: 'follow',
                    headers:{
                        'Authorization': 'Bearer ' + token
                    }

                };

                fetch('https://sagapi.coiin.net/public/api/paradasRela',requestOptions)
                    .then(response => response.json())
                    .then(empresas => {
                        let body = ``
                        // console.log(empresas)
                        var i = 0
                        for (i; i < empresas.length; i++) {
                            body += `
                            <tr>
                                <td>${empresas[i].id}</td>
                                <td>${empresas[i].paradaPrincipal}</td>
                                <td>${empresas[i].paradaSecundaria}</td>
                                <td>${empresas[i].tiempo} minutos</td>

                                
                                
                                <td>
                                    <div class="d-grid gap-2 d-md-block">
                                        <button class="btn btn-success" type="button" data-bs-toggle="modal"onclick="editParada(${empresas[i].id})" data-bs-target="#editParada">
                                            <i class="fa-solid fa-pen-to-square"></i> 
                                        </button>

                                        <button class="btn btn-danger"  type="button" onclick="eliminarParada(${empresas[i].id})">
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