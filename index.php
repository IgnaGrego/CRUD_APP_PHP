<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicación CRUD Utilizando Bootstrap 4, PHP-POO, Conexión PDO-MYSQL, Ajax, Datatable & SweetAlert2</title>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
    <link href="https://cdn.datatables.net/v/bs4/dt-2.0.8/datatables.min.css" rel="stylesheet">

</head>
<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="https://www.linkedin.com/in/ignacio-gregoroff/" target="_blank">Ignacio Gregoroff - <i class="fa fa-linkedin"></i></a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Sobre Mi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contacto</a>
            </li>
            </ul>
        </div>
    </nav>

    <div class="container">
          <div class="row">
                <div class="col-lg-12">
                    <h4 class="text-center text-danger font-weight-normal my-3">Aplicación CRUD Utilizando Bootstrap 4, PHP-POO, Conexión PDO-MYSQL, Ajax, Datatable & SweetAlert2</h4>
                </div>
            </div>
        


        <div class="row">
            <div class="col-lg-6">
                <h4 class="mt-2 text primary">Todos los Usuarios</h4>
            </div>
            <div class="col-lg-6">
                
                <button type="button" class="btn btn-primary m-1 float-right" data-toggle="modal" data-target="#addModal"><i class="fas fa-user-plus fa-lg"></i>&nbsp;Agregar Usuario</button>

                <a href="action.php?export=excel" class="btn btn-success m-1 float-right"><i class="fas fa-table fa-lg"></i>&nbsp;&nbsp;Exportar a Excel</a>

            </div>  
        </div>
        <hr class="my-1">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive" id="showUser">
                    <h3 class="text-center text-success" style="margin-top:150px;">Cargando...</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Nuevo Usuario -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Agregar Nuevo Usuario</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body px-4">
                <form action="" method="post" id="form-data">
                    <div class="form-group">
                        <input type="text" name="fname" class="form-control" placeholder="Nombre" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="lname" class="form-control" placeholder="Apellido" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" oninvalid="this.setCustomValidity('Ingrese formato de email correcto (example@example.com)')" class="form-control" placeholder="Correo Electronico" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone"  class="form-control" placeholder="Telefono" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="insert" id="insert"  required class="btn btn-danger btn-block">
                    </div>
                </form>
            </div>
            
            
        </div>
        </div>
    </div>


    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Editar Usuario</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body px-4">
                <form action="" method="post" id="edit-form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <input type="text" name="fname" id="fname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="lname" id="lname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="update" id="update"  required class="btn btn-primary btn-block">
                    </div>
                </form>
            </div>
            
            
        </div>
        </div>
    </div>




    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js">
        
    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a4c00a89bc.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs4/dt-2.0.8/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script type="text/javascript">

            $(document).ready(function() {
                //Muestra todos los usuarios
                showAllUsers();

                //trae todos los usuarios mediante Ajax.
                function showAllUsers() { 
                    $.ajax({
                        url: "action.php",
                        type: "POST",
                        data: {action: "view"},
                        success: function(response){
                            //console.log(response);
                            $("#showUser").html(response);
                            $("table").DataTable({
                                table: [0, 'desc']
                            });
                        }
                    }); 
                } // <-- Cierre de showAllUsers()


                //Insert Ajax request
                $("#insert").click(function(e){

                    
                    if($("#form-data")[0].checkValidity()){ //este metodo chequea validacion de campos.

                        e.preventDefault();
                        
                        $.ajax({
                            url: "action.php",
                            type: "POST",
                            data: $("#form-data").serialize()+ "&action=insert",
                            success: function(response){

                                console.log(response);
                                
                                Swal.fire({
                                    title: '¡Usuario agregado Exitosamente!'
                                });

                                $('#addModal').modal('hide');
                                $('#form-data')[0].reset();
                                showAllUsers();



                            }
                        });
                    }
                });

                //Edit user
                $('body').on("click", ".editBtn", function(e){
                    
                    e.preventDefault();
                    edit_id = $(this).attr('id');

                    $.ajax({
                        url: "action.php",
                        type: "POST",
                        data: {edit_id: edit_id},
                        success: function (response) {
                            
                            data = JSON.parse(response); //Se transforma a JS el JSON.
                            console.log(data)
                            //Se asignan los valores a cada campo de la BD.
                            $('#id').attr("value",data.id);
                            $('#fname').attr("value",data.first_name);
                            $('#lname').attr("value",data.last_name);
                            $('#email').attr("value",data.email);
                            $('#phone').attr("value",data.phone);



                        }
                    });

                })

                //Delete User AJAX request.
                $("body").on("click", ".delBtn", function(e){

                    e.preventDefault();
                    var tr = $(this).closest('tr');
                    del_id = $(this).attr('id');

                    Swal.fire({
                    title: "¿Estás seguro que quieres Borrar este Contacto?",
                    text: "No podrás revertir los cambios.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Borrar"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                                url: "action.php",
                                type: "POST",
                                data: {del_id: del_id},
                                success:function(response) {

                                    tr.css('background-color', '#ff6666');
                                    Swal.fire(
                                        'Borrado',
                                        'Usuario Borrado Exitosamente',
                                        'success'
                                    )

                                    showAllUsers();

                                }
                        });
                    }
                    });
                });



                //Update User AJAX request.
                $("#update").click(function(e){

                    
                    if($("#edit-form-data")[0].checkValidity()){ //este metodo chequea validacion de campos.

                        e.preventDefault();
                        
                        $.ajax({
                            url: "action.php",
                            type: "POST",
                            data: $("#edit-form-data").serialize()+ "&action=update",
                            success: function(response){

                                console.log(response);
                                
                                Swal.fire({
                                    title: '¡Usuario Modificado Exitosamente!'
                                });

                                $('#editModal').modal('hide');
                                $('#edit-form-data')[0].reset();

                                showAllUsers();



                            }
                        });
                    }
                });

                // Show User Details
                $("body").on("click", ".infoBtn", function(e){

                    e.preventDefault();
                    info_id = $(this).attr('id'); //Agarra infoBtn y encuentra la variable de ID.

                    //Envio ajax
                    $.ajax({
                        url: "action.php",
                        type: "POST",
                        data: {info_id:info_id},
                        success: function (response) {

                            data = JSON.parse(response);
                            Swal.fire({
                                title: '<strong> Informacion de Usuario: ID('+data.id+')</strong>',
                                type: 'info',
                                html: '<b>Nombre: </b>' + data.first_name + '<br><b>Apellido: </b>' + data.last_name + '<br><b> Email : </b>' + data.email + '<br><b>Telefono : </b>' + data.phone,
                                showCancelButton : true,
                            })

                            
                        }
                    });
                

                });


            });

    </script>
    

    </body>
</html>