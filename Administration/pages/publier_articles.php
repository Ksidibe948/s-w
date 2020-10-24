<!-- la partie php -->
<?php  
        session_start();
        if ( isset($_GET['id']) AND $_GET['id']==$_SESSION['id']) {
            $getid=intval($_GET['id']);
            $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
            $req=$bdd->prepare('SELECT *FROM administrateurs WHERE id=?');
            $req->execute(array($getid));
            $info=$req->fetch();
            
        } else {
            header('Location:admin.php?page=erreurs');
        }
        
?>
 <?php  
    if (isset($_SESSION['id']) AND $_SESSION['id']==$info['id'] ) 
    {
      $_SESSION['id']=$info['id'];
      $_SESSION['nom']=$info['nom'];
      $_SESSION['images']=$info['images'];
      $_SESSION['email']=$info['email'];
      $_SESSION['date_inscription']=$info['date_inscription'];
    }
?>
<?php  
         $infos=$bdd->prepare("SELECT id, publier, titre,contenu,images,DATE_FORMAT(date,'%d/%m/%y à %Hh%imin%ss') AS date FROM articles WHERE id_administrateurs =? AND publier=0 ORDER BY date DESC");
         $infos->execute(array($getid));?>

<!-- la partie html -->
<!DOCTYPE html>
<html lang="en">
<head>
     <link rel="stylesheet" href="../Administration/css/table.css">
    <link rel="stylesheet" href="../Administration/bootstrap/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav class=" col navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand col" href="#">w&k</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item  mr-5">
      <a class="nav-link" href="admin.php?page=tablaux&id=<?=$_SESSION['id']?>">
            <path fill-rule="evenodd" d="M1.464 10.536a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3.5a.5.5 0 0 1-.5-.5v-3.5a.5.5 0 0 1 .5-.5z"/>
            <path fill-rule="evenodd" d="M5.964 10a.5.5 0 0 1 0 .707l-4.146 4.147a.5.5 0 0 1-.707-.708L5.257 10a.5.5 0 0 1 .707 0zm8.854-8.854a.5.5 0 0 1 0 .708L10.672 6a.5.5 0 0 1-.708-.707l4.147-4.147a.5.5 0 0 1 .707 0z"/>
            <path fill-rule="evenodd" d="M10.5 1.5A.5.5 0 0 1 11 1h3.5a.5.5 0 0 1 .5.5V5a.5.5 0 0 1-1 0V2h-3a.5.5 0 0 1-.5-.5zm4 9a.5.5 0 0 0-.5.5v3h-3a.5.5 0 0 0 0 1h3.5a.5.5 0 0 0 .5-.5V11a.5.5 0 0 0-.5-.5z"/>
            <path fill-rule="evenodd" d="M10 9.964a.5.5 0 0 0 0 .708l4.146 4.146a.5.5 0 0 0 .708-.707l-4.147-4.147a.5.5 0 0 0-.707 0zM1.182 1.146a.5.5 0 0 0 0 .708L5.328 6a.5.5 0 0 0 .708-.707L1.889 1.146a.5.5 0 0 0-.707 0z"/>
            <path fill-rule="evenodd" d="M5.5 1.5A.5.5 0 0 0 5 1H1.5a.5.5 0 0 0-.5.5V5a.5.5 0 0 0 1 0V2h3a.5.5 0 0 0 .5-.5z"/>
            </svg><span class="sr-only">(current)</span>
            Tableau de bord
        </a>
      </li>
      <li class="nav-item mr-5">
      <a class="nav-link" href="admin.php?page=articles&id=<?=$_SESSION['id']?>">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
        </svg>
         Nouveaux articles
        </a>
      </li>
      <li class="nav-item active mr-5">
        <a class="nav-link" href="">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cursor-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103z"/>
        </svg>
        Publier des articles
        </a>
      </li>
    </ul>
    <a href="admin.php?page=modification_profil" class="btn btn btn-lg active" role="button" aria-pressed="true">
    <?="<img src='".$_SESSION['images']."' class='images' style='width:1.5rem;' alt=''>" ;?>
   <?= $_SESSION['nom'] ?>
   <a href="admin.php?page=deconnexion" class="text-dark">Déconnexion</a>
    </a>

  </div>
</nav>
    <div class="container">
    <?php
    while($donnes=$infos->fetch())
    {
        ?> 
         <div class="row">
            <div class="col-lg-3"></div>
          <div class="col-lg-8">
        <div class="card mb-3 shadow-lg" style="max-width: 600px; ">
         <div class="row no-gutters">
        <div class="col-md-4">
        <?="<img src='".$donnes['images']."' alt='' class='d-block w-100'>" ;?>
        
        </div>
        <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title text-center"><?=  $donnes['titre']?></h5>
        <p class="card-text"><?= substr($donnes['contenu'],0,100) ?></p>
        <p class='ml-5'><a class="btn btn-primary" href="admin.php?page=modification_articles&id=<?=  $donnes['id']?>" role="button">Modifier</a> <a class="btn btn-danger ml-5" href="admin.php?page=supprimer_articles&id=<?=  $donnes['id']?>" role="button">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
        </svg>
            Suppimer
        </a></p>
        <p class="card-text text-right"><small class="text-muted"><?=$donnes['date'] ?></small></p>
      </div>
      <br>
    </div>
  </div>
</div>
        
        </div>
        </div> 
        <?php
    }
    
     ?> 
   
     </div>
   <script src="../Administration/bootstrap/bootstrap.min.js"></script> 
   <script src="../Administration/bootstrap/jquery-3.5.1.js"></script>
</body>
</html>