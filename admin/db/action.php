<?php

 $conn = new mysqli("localhost", "root", "", "condominio");

 if ($conn->connect_error) {
     die("Problemas na ligação à Base de Dados".$conn->connect_error);
 }



    // Insert 
    if(isset($_POST['add'])){
        $data=$_POST['data'];
        $descricao=$_POST['descricao'];
        $id_condomino=$_POST['id_condomino'];
        $id_despesa=$_POST['id_despesa'];
        $id_receita=$_POST['id_receita'];
        $valor=$_POST['valor'];
        $tipo=$_POST['tipo'];

        $comprovativo=$_POST['comprovativo']['name'];
        $upload="../uploads/".$comprovativo;

        $query="INSERT INTO banco(data, descricao, id_condomino, id_despesa, id_receita, valor, tipo, comprovativo) VALUES (?,?,?,?,?,?,?,?)";
        $stmt=$conn->prepare($query);
        $stmt->bind_param("sssiiids", $data, $descricao, $id_condomino, $id_despesa, $id_receita, $valor, $tipo, $upload);
        $stmt->execute();
        move_uploaded_file($_FILES['comprovativo']['tmp_name'], $upload);

        header('location:../index.php');

    }
?>