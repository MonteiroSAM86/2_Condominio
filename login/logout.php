<?php
/* Log out process, unsets and destroys session variables */
session_start();
session_unset();
session_destroy(); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Erro</title>
  <?php include 'css/css.html'; ?>
</head>

<body>
    <div class="form">
          <h1>Obrigado por nos visitar</h1>
              
          <p><?= 'Efetuou o logout!'; ?></p>
          
          <a href="../"><button class="button button-block">Home</button></a>

    </div>
</body>
</html>
