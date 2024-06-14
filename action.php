<?php

    require_once 'db.php';

    //Llamo al objeto que busca datos de la BD y esta ubicado en el Modelo
    $db = new Database();

    if(isset($_POST['action']) && $_POST['action'] == "view" ) {

        $output = '';
        $data = $db->read();
        
        //Imprime el array que se solicita a la BD.
        //print_r($data);

        if($db->totalRowCount() > 0) {
            $output .= '<table class="table table-striped table-sm table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $row) {

                $output .=
                
                    '<tr class="text-center text-secondary">

                        <td>'.$row['id'].'</td>
                        <td>'.$row['first_name'].'</td>
                        <td>'.$row['last_name'].'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['phone'].'</td>

                        <td>
                            <a href="#" title="View Details" class="text-success infoBtn" id="'.$row['id'].'"><i class="fas  fa-info-circle fa-lg"></i>&nbsp;</a>

                            <a href="#" title="Editar Usuario" class="text-primary editBtn" data-toggle="modal" data-target="#editModal" id="'.$row['id'].'"><i class="fas fa-edit fa-lg"></i>&nbsp;</a>

                            <a href="#" title="Borrar Usuario" class="text-danger delBtn" id="'.$row['id'].'"><i class="fas fa-trash-alt fa-lg"></i>&nbsp;</a>

                        </td>

                    </tr>';

            } 

            $output .= '</tbody></table>';
            echo $output;


        } else {
            echo '<h3 class="text-center text-secondary mt-5"> No hay Usuarios Registrados en la Base de Datos </h3>';
        }

        
    }

    //Creacion de Nuevo Usuario
    if(isset($_POST['action']) && $_POST['action'] == "insert") {

        

        //Se preparan los datos en variables para luego ser asignados a la base de datos.
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $db->insert($fname,$lname,$email,$phone);
        
    }

    //Update de Usuario Existente
    if(isset($_POST['action']) && $_POST['action'] == "update") {

        //Se preparan los datos en variables para luego ser asignados a la base de datos.
        $id = $_POST['id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $db->update($id,$fname,$lname,$email,$phone);
        
    }

    if(isset($_POST['edit_id'])){

        $id = $_POST['edit_id'];

        $row = $db->getUserById($id); // Se obtienen los datos del usuario segun ID que es Primary Key
        
        echo json_encode($row); //Se envia en formato JSON para que View procese los datos correctamente.

    }

  

    if(isset($_POST['del_id'])){

        $id = $_POST['del_id'];

        $row = $db->delete($id); // Se obtienen los datos del usuario segun ID que es Primary Key
    }

    if(isset($_POST['info_id'])){

        $info_id = $_POST['info_id'];

        $row = $db->getUserById($info_id); // Se obtienen los datos del usuario segun ID que es Primary Key

        echo json_encode($row);
    }


    if(isset($_GET['export']) &&  $_GET['export'] == "excel"){ //Se usa metodo GET porque viene parametro por URL.

        header("Content-Type: application/xls"); //Crea un tipo de aplicacion XLS
        header("Content-Disposition: attachment; filename=users.xls"); // Le coloca nombre al archivo
        header("Pragma: no-cache"); // Descarga version mas reciente del archivo
        header("Expires: 0");

        $data = $db->read();

        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Nombre</th> <th>Apellido</th> <th>Email</th> <th>Telefono</th></tr>';

        foreach($data as $row){
            echo '<tr>

                <td> '.$row['id'].' </td>
                <td> '.$row['first_name'].' </td>
                <td> '.$row['last_name'].' </td>
                <td> '.$row['email'].' </td>
                <td> '.$row['phone'].' </td>

            </tr>';
        }

        echo '</table>';


    }




?>