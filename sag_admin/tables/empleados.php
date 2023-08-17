

<div class="card mb-4">
                        <div class="card-header">
                            <i class="fa-solid fa-building"></i>
                            Empleados
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>FOLIO</th>
                                            <th>NOMBRE</th>
                                            <th>CORREO</th>
                                            <th>TELEFONO</th>
                                            <th>ROL</th>
                                            <th>ACTIVO</th>

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
    var token = "<?php  echo $_SESSION['token']; ?>"
    var requestOptions = {
                    method: 'GET',
                    redirect: 'follow',
                    headers:{
                        'Authorization': 'Bearer ' + token
                    }
                };

                fetch('https://sagapi.coiin.net/public/api/empleado', requestOptions)
                    .then(response => response.json())
                    .then(empresas => {
                        let body = ``
                        // console.log(empresas)
                        var i = 0
                        for (i; i < empresas.length; i++) {
                            body += `
                            <tr>
                                <td>${empresas[i].id}</td>
                                <td>${empresas[i].nombre}</td>
                                <td>${empresas[i].email}</td>
                                <td>${empresas[i].telefono}</td>
                                <td>${empresas[i].rolNombre}</td>
                                <td>${empresas[i].estado}</td>
                                
                                <td>
                                    <div class="d-grid gap-2 d-md-block">
                                        <button class="btn btn-success" type="button" data-bs-toggle="modal"onclick="editUsuario(${empresas[i].id})" data-bs-target="#edit">
                                            <i class="fa-solid fa-pen-to-square"></i> 
                                        </button>

                                        <button class="btn btn-danger"  type="button" onclick="eliminarGerente(${empresas[i].id})">
                                            <i class="fa-solid fa-trash-can"></i> 
                                        </button>
                                    </div> 
                                </td>
                            </tr>`
                        }
                        document.querySelector('#dataTable tbody').innerHTML = body
                    })
}
</script>