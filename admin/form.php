<?php
// Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

#Ligação Base de Dados
require_once 'db/dbase.php';

$objUser = new User();

 #LOGIN
   /* Displays user information and some useful messages */
   session_start();
   // Check if user is logged in using the session variable
   if ( $_SESSION['logged_in'] != 1 ) {
     $_SESSION['message'] = "Deve efetuar o login antes de visitar o seu portal!";
     header("location: login/error.php");    
   }
   else {
     // Makes it easier to read
     $first_name = $_SESSION['first_name'];
     $last_name = $_SESSION['last_name'];
     $email = $_SESSION['email'];
     $active = $_SESSION['active'];
   }
   
     // Display message about account verification link only once
   if ( isset($_SESSION['message']) ) {
     echo $_SESSION['message'];
                 
     // Don't annoy the user with more messages upon page refresh
     unset( $_SESSION['message'] );
   }
   
   // Keep reminding the user this account is not active, until they activate
   if ( !$active ){
     echo '<div class="info"> A sua conta não foi verificada, por favor confirme no seu e-mail clicando no link!</div>';
   }
   
   


// GET ok
if(isset($_GET['edit_id'])){
    $id = $_GET['edit_id'];
    $stmt = $objUser->runQuery("SELECT * FROM banco WHERE id_banco=:id");
    $stmt->execute(array(":id" => $id));
    $rowUser = $stmt->fetch(PDO::FETCH_ASSOC);
}else{
  $id = null;
  $rowUser = null;
}

// POST
if(isset($_POST['btn_save'])){
  $data   = strip_tags($_POST['data']);
  $descricao  = strip_tags($_POST['descricao']);//falta
  $id_condomino   = strip_tags($_POST['id_condomino']);
  $id_despesa   = strip_tags($_POST['id_despesa']);
  $id_receita   = strip_tags($_POST['id_receita']);
  $valor   = strip_tags($_POST['valor']);
  $tipo   = strip_tags($_POST['tipo']);

  try{
     if($id != null){
       if($objUser->update($data, $descricao, $id_condomino, $id_despesa, $id_receita, $valor, $tipo, $id)){
         $objUser->redirect('index.php?updated');
       }
     }else{
       if($objUser->insert($data, $descricao, $id_condomino, $id_despesa, $id_receita, $valor, $tipo)){
         $objUser->redirect('index.php?inserted');
       }else{
         $objUser->redirect('index.php?error');
       }
     }
  }catch(PDOException $e){
    echo $e->getMessage();
  }
}

?>
<!doctype html>
<html lang="pt">
    <head>
        <!-- Head metas, css, and title -->
        <?php require_once 'includes/head.php'; ?>
    </head>
    <body>
        <!-- Header banner -->
        <?php require_once 'includes/header.php'; ?>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar menu -->
                <?php require_once 'includes/sidebar.php'; ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                  <h1 style="margin-top: 10px">Adicionar / Editar movimento da conta corrente</h1>
                  <p>Required fields are in (*)</p>
                  <form  method="post">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input class="form-control" type="text" name="id" id="id" value="<?php print($rowUser['id_banco']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">Data *</label>
                        <input  class="form-control" type="date" name="name" id="name" value="<?php print($rowUser['data']); ?>" required maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="email">Descrição *</label>
                        <input  class="form-control" type="text" name="email" id="email" placeholder="Pagamento do condominio 2020" value="<?php print($rowUser['descricao']); ?>" required maxlength="250">
                    </div>
                    <div class="form-group">
                        <label for="email">ID do Condomino *</label>
                        <input  class="form-control" type="text" name="id_condomino" id="id_condomino" placeholder="11" value="<?php print($rowUser['id_condomino']); ?>" required maxlength="3">
                    </div>
                    <div class="form-group">
                        <label for="email">ID da receita</label>
                        <input  class="form-control" type="text" name="id_despesa" id="id_despesa" placeholder="1" value="<?php print($rowUser['id_despesa']); ?>" maxlength="11">
                    <div class="form-group">
                        <label for="email">ID da receita</label>
                        <input  class="form-control" type="text" name="id_receita" id="id_receita" placeholder="1" value="<?php print($rowUser['id_receita']); ?>" maxlength="11">
                    </div>
                    <div class="form-group">
                        <label for="email">Valor *</label>
                        <input  class="form-control" type="number" name="valor" id="valor" placeholder="100" value="<?php print($rowUser['valor']); ?>" required maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="email">Tipo *</label>
                        <input  class="form-control" type="text" name="tipo" id="tipo" placeholder="trf" value="<?php print($rowUser['tipo']); ?>" required maxlength="3">
                    </div>
                    <input class="btn btn-primary mb-2" type="submit" name="btn_save" value="Guardar">
                  </form>
                </main>
            </div>
        </div>
        <!-- Footer scripts, and functions -->
        <?php require_once 'includes/footer.php'; ?>
    </body>
</html>
