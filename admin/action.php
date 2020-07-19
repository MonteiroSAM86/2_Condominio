<?php

 $conn = new mysqli("localhost", "root", "", "condominio");

 $update=false;

 $id_banco="";
 $data="";
 $descricao="";
 $id_condomino="";
 $id_despesa="";
 $id_receita="";
 $valor="";
 $tipo="";

 if ($conn->connect_error) {
     die("Problemas na ligação à Base de Dados".$conn->connect_error);
 }
 if (!$conn->set_charset('utf8')) {
    printf("Error loading character set utf8: %s\n", $conn->error);
    exit;
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
       
        header('location:index.php?inserted');

    }

    //Edit
    if (isset($_GET['edit'])) {
        $id_banco=$_GET['edit'];

        $query="SELECT * FROM banco WHERE id_banco=?";
        $stmt=$conn->prepare($query);
        $stmt->bind_param("i",$id_banco);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();

        $id_banco=$row['id_banco'];
        $data=$row['data'];
        $descricao=$row['descricao'];
        $id_condomino=$row['id_condomino'];
        $id_despesa=$row['id_despesa'];
        $id_receita=$row['id_receita'];
        $valor=$row['valor'];
        $tipo=$row['tipo'];

        $update=true;
    }

    if(isset($_POST['update'])){
        $id_banco=$_POST['id_banco'];
        $data=$_POST['data'];
        $descricao=$_POST['descricao'];
        $id_condomino=$_POST['id_condomino'];
        $id_despesa=$_POST['id_despesa'];
        $id_receita=$_POST['id_receita'];
        $valor=$_POST['valor'];
        $tipo=$_POST['tipo'];

        $query="UPDATE banco SET data=?, descricao=?, id_condomino=?, id_despesa=?, id_receita=?, valor=?, tipo=? WHERE id_banco=?";
        $stmt=$conn->prepare($query);
        $stmt->bind_param("sssssssi", $data, $descricao, $id_condomino, $id_despesa, $id_receita, $valor, $tipo, $id_banco);
        $stmt->execute();

        
        header('location:index.php?updated');

    }

    //Delete
    if(isset($_GET['delete'])){
        $id=$_GET['delete'];
                
        $query="DELETE FROM banco WHERE id_banco=?";
        $stmt=$conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
       
        header('location:index.php?deleted');

    }
?>