<div class="card mb-4">
                        <div class="card-header">
                            <i class="fa-solid fa-building"></i>
                            Gerentes
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
                                            <th>EMPRESA</th>
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
   


                fetch('https://sagapi.coiin.net/public/api/allGerente')
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
                                <td>${empresas[i].nombreEmpresa}</td>
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
                            // console.log(body)
                        }

                        document.querySelector('#dataTable tbody').innerHTML = body
                    })
}
</script>