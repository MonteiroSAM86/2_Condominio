<!--<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow" role="navigation">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="index.php"><?php// echo $first_name.' '.$last_name; ?></a>
  
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
      
  
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="../login/logout.php">Logout</a>
    </li>
  </ul>
</nav>-->

<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand bg-dark" href="index.php"><?php echo $first_name.' '.$last_name; ?>&nbsp;&nbsp;&nbsp;</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">Caracteristicas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Serviços</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Constacos</a>
      </li>
  </div>
  <form class="form-inline" action="/action_page.php">
    <input class="form-control mr-sm-2" type="text" placeholder="Procurar">
    <button class="btn btn-primary" type="submit">Search</button>
  </form>
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="../login/logout.php">Logout</a>
        </li>
      </ul>
    </ul>
    </nav>
