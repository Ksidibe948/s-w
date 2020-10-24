
 <!-- la partie de connexion -->
 <?php
  session_start();
  if ( isset($_SESSION['id']))

  {
      $getid=intval($_SESSION['id']);
          $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
          $req=$bdd->prepare('SELECT *FROM utilisateurs WHERE id=?');
          $req->execute(array($getid));
          $info=$req->fetch();
          $_SESSION['id']=$info['id'];
          $_SESSION['email']=$info['email'];
          $_SESSION['images']=$info['images'];
          $_SESSION['nom']=$info['nom'];
          $_SESSION['dates']=$info['dates'];
  }
  
?>
     
     <?php
     if (isset($_GET['id'])) 
     {
       $getid=$_GET['id'];
   $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
   $select=$bdd->prepare("SELECT
        achats_immobilisation.id,
        achats_immobilisation.id_client,
        achats_immobilisation. id_entreprise,
        achats_immobilisation.marchandise,
        achats_immobilisation.quantite,
        achats_immobilisation.prix,
        achats_immobilisation.reduction,
        achats_immobilisation.taux_reduction,
        achats_immobilisation.taux_exompte,
        achats_immobilisation.montant_transport,
        achats_immobilisation.taux_tva,
        achats_immobilisation. montant_emballage,
        achats_immobilisation. montant_avance,
        achats_immobilisation. monyen_payement,
        achats_immobilisation. montant_payement,
        clients.nom,
        clients.telephone,
        clients. adresse,
        clients.logo,
        DATE_FORMAT(date,'%d/%m/%Y à %Hh%imin%ss') AS date
   FROM achats_immobilisation,clients WHERE achats_immobilisation.id_client=clients.id AND achats_immobilisation.id=? ORDER BY id DESC");
   $select->execute(array( $getid));
   $compte=$select->rowcount();
   $donnees=$select->fetch();
}
 ?>

 <!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="../site/css/autor.css">
    <link rel="stylesheet" href="../Administration/bootstrap/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand ml-5 mr-5" href="#">
  <div class='logo text-white mt-1 bg-white '  style='border:solid #A41FDE 2px; width: 50px; text-decoration:underline #A41FDE double;'><span class='logo1' style='padding-left:5px; color:#A41FDE;'>S</span><svg color='#A41FDE'width="1.5em" height="1.5em" color='white' viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
    <path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
    </svg>
    </div>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-5 ">
      <li class="nav-item ">
      <a class="nav-link" href="visteurs.php?page=utilisateurs"> Publications <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active ">
      <a class="nav-link  " href="visteurs.php?page=comptabilite&id=<?=$_SESSION['id'] ?>">Comptabilité</a>
      </li>
      </ul>
      <ul class="navbar-nav ml-auto mr-5 ">
      <li class="nav-item dropdown">
        <a class="nav-link  dropdown-toggle ml-5" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?="<img src='".$_SESSION['images']."' class='images' style='width:2rem ; height:2rem; border-radius:100px ; ' alt=''>" ;?>
       <?= $_SESSION['nom']?>
        </a>
        <div class="dropdown-menu pl-2 mr-5" aria-labelledby="navbarDropdownMenuLink">
        <a class="nav-link " href="visteurs.php?page=donnees_utilisateurs&id=<?=$_SESSION['id'] ?>">Publications </a>
        <a class="nav-link text-dark  " href="visteurs.php?page=publication&id=<?=$_SESSION['id'] ?>">Publier</a>
        <a class="nav-link text-dark  " href="visteurs.php?page=publication&id=<?=$_SESSION['id'] ?>">Profil</a>
        <a class="nav-link text-dark " href="visteurs.php?page=modifier_utilisateurs&id=<?=$_SESSION['id'] ?>"> Modifier  profil</a>
        <a class="nav-link text-dark " href="visteurs.php?page=deconnexion"> 
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-folder-symlink-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2l.04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14h10.348a2 2 0 0 0 1.991-1.819l.637-7A2 2 0 0 0 13.81 3zM2.19 3c-.24 0-.47.042-.684.12L1.5 2.98a1 1 0 0 1 1-.98h3.672a1 1 0 0 1 .707.293L7.586 3H2.19zm9.608 5.271l-3.182 1.97c-.27.166-.616-.036-.616-.372V9.1s-2.571-.3-4 2.4c.571-4.8 3.143-4.8 4-4.8v-.769c0-.336.346-.538.616-.371l3.182 1.969c.27.166.27.576 0 .742z"/>
        </svg> Déconnexion</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<div class="row">
  <div class="col-lg-3">
  <nav class="navbar sticky-top navbar-expand-lg navbar-light ">
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
     <ul  class="navbar-nav mr-auto mt-2 mb-5 mt-lg-0">
      <li class="nav-item ">
      <a class="nav-link " href="visteurs.php?page=utilisateurs"><i class="fas fa-globe-africa"></i> Publications <span class="sr-only">(current)</span></a>
      <a class="nav-link "   href="visteurs.php?page=comptabilite&id=<?=$_SESSION['id'] ?>"><i class="fas fa-calculator"></i> Comptabilité</a>
     <a  class="nav-link " href="visteurs.php?page=comptabilité_generale&id=<?=$_SESSION['id'] ?>"> <i class="fas fa-donate"></i> Comptabilités générales
    </a>
    <a  class="nav-link " href="visteurs.php?page=Stocks&id=<?=$_SESSION['id'] ?>"><i class="fas fa-chart-line"></i>  Stocks</a>
    <a class="nav-link  active" style='color:#A41FDE;' style='color:green;'href="visteurs.php?page=stocks_materiels&id=<?=$_SESSION['id'] ?>"><i class="fas fa-chart-line"></i>Stocks de Materiels</a>
    </li>
    </ul>
  </div>
</nav>
</div>
<div class="container">
<div class="col-lg-9 ">        
   <div class="row ">
     <div class="card w-100 shadow-lg p-3 bg-white " >
      <div class="card-title text-center pt-2" style='color:green;'>
        <p style='  font-size:1.5rem'>Stocks de <h5><?= $donnees['marchandise'] ?></h5></p>
      <h5> Date d'achat: <?= $donnees['date'] ?></h5> 
      <div class="row">
          <div class="col-lg-3"></div>
      <div class="col-lg-3 mt-2 pt-2 pb-2 text-center"style='border:solid black 1px '>
          <h5>Quantite Restant</h5>
      </div>
      <div class="col-lg-3  mt-2 pt-2 pb-2 text-center"style='border:solid black 1px '>
          <h5><?= $donnees['quantite'] ?></h5>
      </div>
      </div>
      </div>
        <div class='imagess'>
        <img src="../site/images/stocks_materiels.webp" class='card-img-top' alt="">
      </div>
      </div>
    
  
  </div>
  </div>
  
        <script src="https://kit.fontawesome.com/3d9f317c2d.js" crossorigin="anonymous"></script>
    <script src="../Administration/bootstrap/bootstrap.min.js"></script>
    <script src="../Administration/bootstrap/jquery-3.5.1.js"></script>
</body>
</html>