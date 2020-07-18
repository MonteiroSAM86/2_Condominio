<?php

 $conn = new mysqli("localhost", "root", "", "crud_users");

 if ($conn->connect_error) {
     die("Problemas na ligação à Base de Dados".$conn->connect_error);
 }



    // Insert 
    if(isset($_POST['add'])){
        $data=$_POST['data'];
        $descricao=$_POST['descricao'];
        
        $doc=$_FILE['comprovativo']['name'];
        $upload="uploads/".$doc;

        $query="INSERT INTO crud_users(name, email, photo) VALUES (?,?,?)";
        $stmt=$conn->prepare($query);
        $stmt->bind_param("sss", $data, $descricao, $upload);
        $stmt->execute();
        move_uploaded_file($_FILES['comprovativo']['tmp_name'], $upload);

        header('location:index.php');

    }
?>