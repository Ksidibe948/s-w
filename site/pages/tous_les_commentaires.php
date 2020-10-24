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
 if (isset($_GET['id_publications'])) {
     $getid=$_GET['id_publications'];
     $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
     $commentaire=$bdd->prepare("SELECT  commentaires.id, commentaires.id_publications, commentaires.commentaire,utilisateurs.nom, utilisateurs.images,DATE_FORMAT(date,  '%d/%m/%Y à %Hh%imin%ss') AS date FROM commentaires, utilisateurs WHERE commentaires.id_utilisateurs=utilisateurs.id AND id_publications=? ORDER BY date DESC ");
     $commentaire->execute(array($getid));
     $commentairesexiste=$commentaire->rowcount();
 }


 ?>
   

        <!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../Administration/bootstrap/bootstrap.min.css">
    <script src="../site/ckeditor/ckeditor.js"></script>
    <script src="../site/ckfinder/ckfinder.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="banner-area">
    <div class="row">
        <div class="col-lg-12">
        <nav class=" col navbar navbar-expand-lg navbar-dark bg-success" style='height:50px'>
    <a class=" col navbar-brand ml-5"  href="#">
    
    <div class='logo text-warning mt-1'  style='border:solid white 2px; width: 50px; text-decoration:underline double;'><span class='logo1'>S</span><svg width="1.5em" height="1.5em" color='white' viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
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
        <li class="nav-item   mr-3">
          <a class="nav-link" href="visteurs.php?page=utilisateurs">Publications <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active  mr-3">
          <a class="nav-link" href="visteurs.php?page=utilisateurs"> Commentaires <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item mr-3">
        <a class="nav-link" href="visteurs.php?page=blogs_utilisateurs">blogs
            </a>
        </li>
        <li class="nav-item dropdown mega-area">
        <a class="nav-link  dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Cours
        </a>
        <div class="dropdown-menu bg-success mega-area" aria-labelledby="navbarDropdown">
          <a class="dropdown-item  text-white" href="#">Comptabilité</a>
          <a class="dropdown-item text-white" href="#">Finances</a>
          <a class="dropdown-item  text-white" href="#">Fiscalité</a>
          <a class="dropdown-item  text-white" href="#">Logistique</a>
          <a class="dropdown-item  text-white" href="#">Marketing</a>
        </div>
      </li>
      </ul>
        <div class='mr-1'>
        <a class="nav-link text-white" href="visteurs.php?page=donnees_utilisateurs&id=<?=$_SESSION['id'] ?>">    
         <?="<img src='".$_SESSION['images']."' class='images' style='width:1.5rem ; height:1.6rem; border-radius:100px ; ' alt=''>" ;?>
           <?= $_SESSION['nom']?>
        </a>
         </div>
        <div class="dropdown ">
        <a class="  btn mr-1 text-warning" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        </svg>  
        </a>
        <div class="dropdown-menu dropdown-menu-right mt-2 bg-success" aria-labelledby="dropdownMenuLink">
        <a class="nav-link text-white text-center" href="visteurs.php?page=publication&id=<?=$_SESSION['id'] ?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi mr-1 bi-brightness-high" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
            </svg>Publier</a>
            <a class="dropdown-item text-white text-center" href="#"> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi mr-1 bi-cursor-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103z"/>
        </svg>SMS</a>
        <a class="nav-link text-white text-center" href="visteurs.php?page=demande&id=<?=$_SESSION['id'] ?>"> 
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi mr-1 bi-emoji-smile" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path fill-rule="evenodd" d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683z"/>
        <path d="M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
        </svg>Demande</a>
        </div>
        </div>
    <div class="dropdown">
    <a class=" dropdown-toggle  text-warning mr-3" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    </a>
    <div class="dropdown-menu dropdown-menu-right bg-success mt-4 mega-menu " style=' width:200px; ' aria-labelledby="dropdownMenuLink">
    <a class="nav-link text-white text-center" href="visteurs.php?page=modifier_utilisateurs&id=<?=$_SESSION['id'] ?>"> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-gear-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 0 0-5.86 2.929 2.929 0 0 0 0 5.858z"/>
        </svg> Modifier Votre profil</a>
        <div class="dropdown-divider"></div>
        <a class="nav-link text-white text-center" href="visteurs.php?page=deconnexion"> 
         <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-folder-symlink-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2l.04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14h10.348a2 2 0 0 0 1.991-1.819l.637-7A2 2 0 0 0 13.81 3zM2.19 3c-.24 0-.47.042-.684.12L1.5 2.98a1 1 0 0 1 1-.98h3.672a1 1 0 0 1 .707.293L7.586 3H2.19zm9.608 5.271l-3.182 1.97c-.27.166-.616-.036-.616-.372V9.1s-2.571-.3-4 2.4c.571-4.8 3.143-4.8 4-4.8v-.769c0-.336.346-.538.616-.371l3.182 1.969c.27.166.27.576 0 .742z"/>
        </svg> Déconnexion</a>
    </div>
    </div>
    </div>
    </nav>

        </div>
    </div>
</div>
  <div class="container">
    <div class="row">
      <div class="col-lg-2"></div>
        <div class="col-lg-8">
          <div class="card">
            <div class="card-header mt-2 text-center text-white bg-success">
              Tous les commentaires
            </div>
        </div>
      </div>
    </div>
  </div>
<?php
    while ( $commentaires=$commentaire->fetch()) {
      ?>
        <div class="container">
          <div class="row">
            <div class="col-lg-2"> </div>
              <div class="col-lg-8">
                <div class="card w-100">
                  <div class="card-body">
                  <?="<img src='".$commentaires['images']."' class='images' style='width:1.5rem ; height:1.6rem; border-radius:100px ; ' alt=''>" ;?> <?= $commentaires['nom'] ?>:
                  <?= $commentaires['commentaire'] ?>
                  <?= $commentaires['date'] ?>
                  <a href="visteurs.php?page=supprimer_tous_commentaire&id=<?=$commentaires['id'] ?>&id_publications=<?= $getid?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                  </svg></a>
                </div>
              </div>
            </div>
          </div>
        </div>             
        <?php

        }
        ?>  
      <div class="container">
    <div class="row">
      <div class="col-lg-2"></div>
        <div class="col-lg-8">
          <div class="card">
            <div class="card-footer  text-center ">
              Fin de commentaire
            </div>
        </div>
      </div>
    </div>
  </div>
    <script src="../Administration/bootstrap/bootstrap.min.js"></script>
    <script src="../Administration/bootstrap/jquery-3.5.1.js"></script>
</body>
</html>
<div class="row pb-2">
                     