<?php
// Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

 #Ligação Base de Dados
 require_once 'db/dbase.php';

 include 'action.php';

 //Ligação com a base de dados
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
 
// Apagar linha ok
if(isset($_GET['delete_id'])){
  $id = $_GET['delete_id'];
  try{
    if($id != null){
      if($objUser->delete($id)){
        $objUser->redirect('index.php?deleted');
      }
    }else{
      var_dump($id);
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
          <div class="row"> <!-- Cabeçalho -->
            <div class="col-md-9 ml-sm-auto col-lg-12 px-4">
              <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-1 mt-2 mb-2 border-bottom">
                <h1 class="text-center text-dark">Conta Corrente</h1>
                <?php
                  $query = "SELECT FORMAT(SUM(IF (id_despesa>0, -1*valor, valor)),2) as saldo from banco";
                  $stmt = $objUser->runQuery($query);
                  $stmt->execute();
                ?>  
                <h5> Saldo
                  <?php 
                    if($stmt->rowCount() > 0){
                      while($rowUser = $stmt->fetch(PDO::FETCH_ASSOC)){
                        print($rowUser['saldo']);
                      }
                    }
                  ?> € 
                </h5>   
              </div>
            </div>
          </div>
          <div class="row"> <!-- Tabela com uma linha e duas colunas -->
            <div class="col-md-3 pt-2 pb-1 mt-2 mb-2 border-right border-bottom"> <!-- Formulário -->
              <h5 class="text-center text-secondary">Adicionar movimento</h5>
              <p>Preenchimento obrigatório (*)</p>
              <form action="action.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="Data">Data *</label>
                <input type="date" name="data" id="data" class="form-control" placeholder="" aria-describedby="helpId">
                <small id="helpId" class="text-muted">Coloque a data</small>
              </div>
              <div class="form-group">
                <label for="Descrição">Descrição *</label>
                <input type="text" name="descricao" id="descricao" class="form-control" placeholder="" aria-describedby="helpId">
                <small id="helpId" class="text-muted">Coloque a descrição do movimento</small>
              </div>
              <div class="form-group">
                <label for="Id do Condómino">ID do Condómino *</label>
                <input type="number" name="id_condomino" id="id_condomino" class="form-control" placeholder="" aria-describedby="helpId">
                <small id="helpId" class="text-muted">Coloque a identificação do ID do Condómino</small>
              </div>
              <div class="form-group">
                <label for="ID da despesa">Id da despesa</label>
                <input type="number" name="id_despesa" id="id_despesa" class="form-control" placeholder="" aria-describedby="helpId">
                <small id="helpId" class="text-muted">Coloque o ID da despesa</small>
              </div>
              <div class="form-group">
                <label for="Ida da receita">Id da receita</label>
                <input type="number" name="id_receita" id="id_receita" class="form-control" placeholder="" aria-describedby="helpId">
                <small id="helpId" class="text-muted">Coloque o ID da receita</small>
              </div>
              <div class="form-group">
                <label for="Valor">Valor *</label>
                <input type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" name="valor" id="valor" class="form-control" placeholder="" aria-describedby="helpId">
                <small id="helpId" class="text-muted">Valor do movimento</small>
              </div>
              <div class="form-group">
                <label for="Tipo de Operação">Tipo de Operação *</label>
                <input type="text" name="tipo" id="tipo" class="form-control" placeholder="" aria-describedby="helpId">
                <small id="helpId" class="text-muted">Coloque se a operação é "trf" ou "num"</small>
              </div>
              <button type="submit" name="add" class="btn btn-primary btn-block mb-2">Adicionar Registo</button>
              </form>
            </div>
            
            <div class="col-md-9 pt-2 pb-1 mt-2 mb-2"> <!-- Exibição do conteudo -->
              <h5 class="text-center text-secondary">Movimentos</h5>
              <table id="example" class="table table-hover table-sm">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Data</th>
                    <th>Operação</th>
                    <th>Entidade</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th></th>
                  </tr>
                </thead>
                <?php
                  $query = "SELECT b.id_banco, b.comprovativo, b.tipo, b.data, f.piso, b.descricao, FORMAT(IF (b.id_despesa>0, -1*b.valor, b.valor),2) AS valor, CASE WHEN b.id_despesa>0 THEN 'Despesa' WHEN b.id_receita>0 THEN 'Receita' ELSE NULL END AS opr from banco b join condominos c on c.id_condomino = b.id_condomino join fracoes f on f.id_condomino = c.id_condomino";
                  $stmt = $objUser->runQuery($query);
                  $stmt->execute();
                ?>
                <tbody>
                  <?php 
                    if($stmt->rowCount() > 0){
                    while($rowUser = $stmt->fetch(PDO::FETCH_ASSOC)){
                  ?>
                  <tr>
                    <td><?php print($rowUser['id_banco']); ?></td>
                    <td><?php print($rowUser['data']); ?></td>
                    <td><?php print($rowUser['opr']); ?></td>
                    <td><?php print($rowUser['piso']); ?></td>
                    <td><?php print($rowUser['descricao']); ?></td>
                    <td><?php print($rowUser['valor']); ?> €</td>
                    <td>
                      <a class="confirmation" href="form.php?edit_id=<?php print($rowUser['comprovativo']); ?>">
                        <span data-feather="file"></span>
                      </a> | 
                      <a class="confirmation" href="form.php?edit_id=<?php print($rowUser['id_banco']); ?>">
                        <span data-feather="edit"></span>
                      </a> | 
                      <a class="confirmation" href="index.php?delete_id=<?php print($rowUser['id_banco']); ?>">
                        <span data-feather="trash"></span>
                      </a>
                    </td>
                  </tr>
                  <?php } } ?>

                </tbody>
              </table>
              <div>
                <?php
                  $update = "SELECT UPDATE_TIME FROM information_schema.tables WHERE  TABLE_SCHEMA = 'condominio' AND TABLE_NAME = 'banco'";
                  $stmt2 = $objUser->runQuery($update);
                  $stmt2->execute();
                
                  if($stmt2->rowCount() > 0){
                    while($rowUser2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                ?>
                <p>Última atualização <?php print($rowUser2['UPDATE_TIME']); ?></p>
                <?php } } ?>
              </div>

            
            </div>
          
          </div> <!-- CONSIDERAR -->
          
          <!-- NÃO APAGAR -->
            <?php
              if(isset($_GET['updated'])){
                echo '<div class="alert alert-info alert-dismissable fade show" role="alert">   <strong>Movimento </strong>atualizado com sucesso.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"> &times; </span>
                </button></div>';
              }else if(isset($_GET['deleted'])){
                echo '<div class="alert alert-info alert-dismissable fade show" role="alert"><strong>Movimento</strong> apagado com sucesso.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"> &times; </span></button></div>';
              }else if(isset($_GET['inserted'])){
                echo '<div class="alert alert-info alert-dismissable fade show" role="alert"><strong>Movimento</strong> inserido com sucesso.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"> &times; </span></button></div>';
              }else if(isset($_GET['error'])){
                echo '<div class="alert alert-info alert-dismissable fade show" role="alert"><strong>Erro com a Base de Dados!</strong> Algo de errado com a sua atividade, tente outra vez!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"> &times; </span></button></div>';
              }
            ?>
            
    
    
    

        <!-- Footer scripts, and functions -->
        <?php require_once 'includes/footer.php'; ?>

        <!-- Custom scripts -->
        <script>
            // JQuery confirmation
            $('.confirmation').on('click', function () {
                return confirm('Tem a certeza que quer apagar este movimento?');
            });
        </script>

</html>
