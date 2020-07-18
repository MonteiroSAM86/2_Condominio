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
        
        $query="INSERT INTO banco(data, descricao, id_condomino, id_despesa, id_receita, valor, tipo) VALUES (?,?,?,?,?,?,?)";
        $stmt=$conn->prepare($query);
        $stmt->bind_param("sssssss", $data, $descricao, $id_condomino, $id_despesa, $id_receita, $valor, $tipo);
        $stmt->execute();
       
        header('location:index.php');

    }
?>