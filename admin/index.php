<?php
// Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

 #Ligação Base de Dados
 include 'action.php';

 
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
                  $stmt=$conn->prepare($query);
                  $stmt->execute();
                  $result=$stmt->get_result();
                ?>  
                <h5> Saldo
                  <?php 
                    while($rowUser = $result->FETCH_ASSOC()){
                        print($rowUser['saldo']);
                      }
                  ?> € 
                </h5>   
              </div>
            </div>
          </div>
          <div class="row"> <!-- Tabela com uma linha e duas colunas -->
            <div class="col-md-3 pt-2 pb-1 mt-2 mb-2 border-right border-bottom"> <!-- Formulário -->
              <h5 class="text-center text-secondary">Adicionar Registo</h5>
              <form action="action.php" method="post">
              <input type="hidden" name="id_banco" value="<?= $id_banco; ?>">
              <div class="form-group">
                <label for="Data">Data *</label>
                <input type="date" name="data" value="<?= $data; ?>" id="data" class="form-control" placeholder="" aria-describedby="helpId" required>
                <small id="helpId" class="text-muted">Coloque a data</small>
              </div>
              <div class="form-group">
                <label for="Descrição">Descrição *</label>
                <input type="text" name="descricao" value="<?= $descricao; ?>" id="descricao" class="form-control" placeholder="" aria-describedby="helpId" required>
                <small id="helpId" class="text-muted">Coloque a descrição do registo</small>
              </div>
              <div class="form-group">
                <label for="ID do Condómino">ID do Condómino *</label>
                <input type="text" name="id_condomino" value="<?= $id_condomino; ?>" id="id_condomino" class="form-control" placeholder="" aria-describedby="helpId" required>
                <small id="helpId" class="text-muted">Coloque o ID do Condómino *</small>
              </div>
              <div class="form-group">
                <label for="ID da Despesa">ID da Despesa *</label>
                <input type="text" name="id_despesa" value="<?= $id_despesa; ?>" id="id_despesa" class="form-control" placeholder="" aria-describedby="helpId" required>
                <small id="helpId" class="text-muted">Coloque o ID da Despesa</small>
              </div>
              <div class="form-group">
                <label for="ID da Receita">ID da Receita *</label>
                <input type="text" name="id_receita" value="<?= $id_receita; ?>" id="id_receita" class="form-control" placeholder="" aria-describedby="helpId" required>
                <small id="helpId" class="text-muted">Coloque o ID da Despesa</small>
              </div>
                    
              <div class="form-group">
                <label for="Valor">Valor *</label>
                <input type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" name="valor" value="<?= $valor; ?>" id="valor" class="form-control" placeholder="" aria-describedby="helpId" required>
                <small id="helpId" class="text-muted">Valor do registo</small>
              </div>
              <div class="form-group">
                <label for="Tipo">Tipo de Operação *</label>
                <input type="text" name="tipo" value="<?= $tipo; ?>" id="tipo" class="form-control" placeholder="" aria-describedby="helpId" required>
                <small id="helpId" class="text-muted">Coloque "num" ou "trf"""</small>
              </div>
              <?php  if($update==true){ ?>
                <button type="submit" name="update" class="btn btn-success btn-block mb-2">Atualizar Registo</button>
              <?php } else {?>
              <button type="submit" name="add" class="btn btn-primary btn-block mb-2">Adicionar Registo</button> <?php } ?>
              </form>
              <p>Preenchimento obrigatório (*)</p>
            </div>
            
            <div class="col-md-9 pt-2 pb-1 mt-2 mb-2"> <!-- Exibição do conteudo -->
            <?php
              if(isset($_GET['updated'])){
                echo '<div class="alert alert-info alert-dismissable fade show text-center" role="alert">   <strong>Registo </strong>atualizado com sucesso.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"> &times; </span>
                </button></div>';
              }else if(isset($_GET['deleted'])){
                echo '<div class="alert alert-info alert-dismissable fade show text-center" role="alert"><strong>Registo</strong> eliminado com sucesso.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"> &times; </span></button></div>';
              }else if(isset($_GET['inserted'])){
                echo '<div class="alert alert-info alert-dismissable fade show text-center" role="alert"><strong>Registo</strong> inserido com sucesso.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"> &times; </span></button></div>';
              }else if(isset($_GET['error'])){
                echo '<div class="alert alert-info alert-dismissable fade show text-center" role="alert"><strong>Erro com a Base de Dados!</strong> Algo de errado com a sua atividade, tente outra vez!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"> &times; </span></button></div>';
              }
            ?>
              <h5 class="text-center text-secondary">Registos</h5>
              <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Data</th>
                    <th>Operação</th>
                    <th>Entidade</th>
                    <th>Descrição</th>
                    <th class="text-center">Valor</th>
                    <th></th>
                  </tr>
                </thead>
                <?php
                  $query = "SELECT b.id_banco, b.tipo, b.data, f.piso, b.descricao, FORMAT(IF (b.id_despesa>0, -1*b.valor, b.valor),2) AS valor, CASE WHEN b.id_despesa>0 THEN 'Despesa' WHEN b.id_receita>0 THEN 'Receita' ELSE NULL END AS opr from banco b join condominos c on c.id_condomino = b.id_condomino join fracoes f on f.id_condomino = c.id_condomino";
                  $stmt=$conn->prepare($query);
                  $stmt->execute();
                  $result=$stmt->get_result();
                ?>
                <tbody>
                  <?php 
                    while($rowUser = $result->FETCH_ASSOC()){
                  ?>
                  <tr>
                    <td><?php print($rowUser['id_banco']); ?></td>
                    <td><?php print($rowUser['data']); ?></td>
                    <?php 
                      if ($rowUser['opr'] == "Despesa") { ?>
                        <td class='text-danger'><?php print($rowUser['opr']);?></td>
                        <?php } else{?>
                          <td class='text-success'><?php print($rowUser['opr']);?></td>
                        <?php  }  ?>

                    <td><?php print($rowUser['piso']); ?></td>
                    <td><?php print($rowUser['descricao']); ?></td>
                    <td class="text-right"><?php print($rowUser['valor']); ?> €</td>
                    <td class="text-center">
                      <a href="index.php?edit=<?php print($rowUser['id_banco']);?>">
                        <span data-feather="edit"></span>
                      </a>&nbsp;&nbsp;&nbsp; 
                      <a class="confirmation" href="action.php?delete=<?php print($rowUser['id_banco']); ?>">
                        <span data-feather="trash"></span>
                      </a>
                    </td>
                  </tr>
                  <?php } ?>

                </tbody>
              </table>
              <div>
                <?php
                  $update = "SELECT UPDATE_TIME FROM information_schema.tables WHERE  TABLE_SCHEMA = 'condominio' AND TABLE_NAME = 'banco'";
                  $stmt2=$conn->prepare($update);
                  $stmt2->execute();
                  $result2=$stmt2->get_result();
                
                 while($rowUser2 = $result2->FETCH_ASSOC()){
                ?>
                <p>Última atualização <?php print($rowUser2['UPDATE_TIME']); ?></p>
                <?php } ?>
              </div>

            
            </div>
          
          </div> 
          
          

        <!-- Footer scripts, and functions -->
        <?php require_once 'includes/footer.php'; ?>

        <!-- Custom scripts -->
        <script>
            // JQuery confirmation
            $('.confirmation').on('click', function () {
                return confirm('Tem a certeza que pretende apagar este registo?');
            });
        </script>

</html>
