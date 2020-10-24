
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../site/css/acceu.css">
    <link rel="stylesheet" href="../Administration/bootstrap/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="banner-area">
        <div class="row">
            <div class="col-lg-12">
            <nav class=" col navbar navbar-expand-lg navbar-light bg-light">
        <a class=" col navbar-brand ml-5"  href="#">
        
        <div class='logo'><span class='logo1'>S</span><svg width="1.5em" height="1.5em" color='green' viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
        <path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
        </svg>
          </div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbar">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active mr-">
              <a class="nav-link" href="visteurs.php?page=accueil">Accueil <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item mr">
              <a class="nav-link" href="visteurs.php?page=blogs">blogs
                </a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="visteurs.php?page=cours" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Cours
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Comptabilité</a>
              <a class="dropdown-item" href="#">Finances</a>
              <a class="dropdown-item" href="#">Fiscalité</a>
              <a class="dropdown-item" href="#">Logistique</a>
              <a class="dropdown-item" href="#">Marketing</a>
            </div>
          </li>
          </ul>
          <a class="nav-link" href="visteurs.php?page=connexion"> 
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7.5-3a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
            <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
            </svg>
              Créer un compte
          </a>
          <a class="nav-link" href="visteurs.php?page=connexion"> 
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                </svg>
              Connexion
          </a>
        </div>
        </nav>
            </div>
        </div>
    </div>
    <div class="container">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Bonjour!</strong>Bienvenue sur la page d'accueil
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    </div>
    <script src="../Administration/bootstrap/bootstrap.min.js"></script>
    <script src="../Administration/bootstrap/jquery-3.5.1.js"></script>
</body>
</html>