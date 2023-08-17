<div class="card mb-4">
    <div class="card-header">
        <i class="fa-solid fa-building"></i>
        ASISTENCIAS
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table">
                <thead>
                    <tr>
                        <th>NOMBRE</th>
                        <th>PARADA</th>
                        <th>RUTA</th>
                        <th>FECHA/HORA</th>
                        

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
    var token = "<?php  echo $_SESSION['token']; ?>"
    var requestOptions = {
                    method: 'GET',
                    redirect: 'follow',
                    headers:{
                        'Authorization': 'Bearer ' + token
                    }
                };

                fetch('https://sagapi.coiin.net/public/api/asistenciaUser', requestOptions)
                    .then(response => response.json())
                    .then(empresas => {
                        let body = ``
                        console.log(empresas)
                        var i = 0
                        for (i; i < empresas.length; i++) {
                            body += `
                            <tr>
                                <td>${empresas[i].nombre}</td>
                                <td>${empresas[i].parada_nombre}</td>
                                <td>${empresas[i].ruta_nombre}</td>
                                <td>${empresas[i].created_at}</td>
                                
                            </tr>`
                            // console.log(body)
                        }

                        document.querySelector('#dataTable tbody').innerHTML = body
                    })
}


</script>