<?php

require_once 'db.php';

class User {
    private $conn;

    // Constructor
    public function __construct(){
      $database = new Database();
      $db = $database->dbConnection();
      $this->conn = $db;
    }


    // Execute queries SQL
    public function runQuery($sql){
      $stmt = $this->conn->prepare($sql);
      return $stmt;
    }

    // Insert FALTA CONFUGURAR
    public function insert($data, $descricao, $id_condomino, $id_despesa, $id_receita, $valor, $tipo){
      try{
        $stmt = $this->conn->prepare("INSERT INTO banco (data, descricao, id_condomino, id_despesa, id_receita, valor, tipo) VALUES(:data, :descricao, :id_condomino, :id_despesa, :id_receita, :valor, :tipo)");
        $stmt->bindparam(":data", $data);
        $stmt->bindparam(":descricao", $descricao);
        $stmt->bindparam(":id_condomino", $id_condomino);
        $stmt->bindparam(":id_despesa", $id_despesa);
        $stmt->bindparam(":id_receita", $id_receita);
        $stmt->bindparam(":valor", $valor);
        $stmt->bindparam(":tipo", $tipo);
        $stmt->execute();
        return $stmt;
      }catch(PDOException $e){
        echo $e->getMessage();
      }
    }


    // Update Insert 
    public function update($data, $descricao, $id_condomino, $id_despesa, $id_receita, $valor, $tipo, $id){
        try{
          $stmt = $this->conn->prepare("UPDATE banco SET data = :data, descricao = :descricao, id_condomino = :id_condomino, id_despesa = :id_despesa, id_receita = :id_receita, valor = :valor, tipo = :tipo WHERE id_banco = :id");
          $stmt->bindparam(":data", $data);
          $stmt->bindparam(":descricao", $descricao);
          $stmt->bindparam(":id_condomino", $id_condomino);
          $stmt->bindparam(":id_despesa", $id_despesa);
          $stmt->bindparam(":id_receita", $id_receita);
          $stmt->bindparam(":valor", $valor);
          $stmt->bindparam(":tipo", $tipo);
          $stmt->bindparam(":id", $id);
          $stmt->execute();
          return $stmt;
        }catch(PDOException $e){
          echo $e->getMessage();
        }
    }


    // Delete Insert FALTA CONFUGURAR
    public function delete($id){
      try{
        $stmt = $this->conn->prepare("DELETE FROM banco WHERE id_banco = :id");
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        return $stmt;
      }catch(PDOException $e){
          echo $e->getMessage();
      }
    }

    // Redirect URL method 
    public function redirect($url){
      header("Location: $url");
    }
}
?>
