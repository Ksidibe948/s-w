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
if (isset ($_GET['id']))
{
   $get=$_GET['id'];
   $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
   $donnees=$bdd->prepare("SELECT publications.id_utilisateurs, publications.fichier, publications.id_publications, publications.contenu,utilisateurs.nom, utilisateurs.images ,DATE_FORMAT(date,  '%d/%m/%Y à %Hh%imin%ss') AS date FROM publications, utilisateurs WHERE publications.id_utilisateurs=utilisateurs.id AND id_publications=?");
   $donnees->execute(array($get));
   $reponses=$donnees->fetch();
}

?>
<?php
  if(isset($_POST['commentaire']) AND !empty($_POST['commentaire']))
   {
   $commentaire=$_POST['commentaire'];
    $req=$bdd->prepare('INSERT INTO commentaires(commentaire,id_utilisateurs,id_publications)VALUES(?,?,?)');
    $req->execute(array($commentaire,$_SESSION['id'], $get));
  }
?>
<?php
$likes=$bdd->prepare("SELECT id FROM likes WHERE id_publications=? ");
$likes->execute(array($_GET['id']));
$likes=$likes->rowcount();

$dislikes=$bdd->prepare("SELECT id FROM dislike WHERE id_publications=? ");
$dislikes->execute(array($_GET['id']));
$dislikes=$dislikes->rowcount();
?>
<?php
$bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
$commentaire=$bdd->prepare("SELECT  commentaires.id, commentaires.id_publications, commentaires.commentaire,utilisateurs.nom, utilisateurs.images,DATE_FORMAT(date,  '%d/%m/%Y à %Hh%imin%ss') AS date FROM commentaires, utilisateurs WHERE commentaires.id_utilisateurs=utilisateurs.id AND id_publications=? ORDER BY date DESC LIMIT 0,20");
$commentaire->execute(array($_GET['id']));
$commentairesexiste=$commentaire->rowcount();
?>
<?php
$bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
$count=$bdd->prepare("SELECT  commentaires.id, commentaires.id_publications, commentaires.commentaire,utilisateurs.nom, utilisateurs.images,DATE_FORMAT(date,  '%d/%m/%Y à %Hh%imin%ss') AS date FROM commentaires, utilisateurs WHERE commentaires.id_utilisateurs=utilisateurs.id AND id_publications=? ORDER BY date DESC LIMIT 0,20");
$count->execute(array($_GET['id']));
$commentairesexiste=$count->rowcount();

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
      <a class="nav-link active" href="visteurs.php?page=utilisateurs"> Publications <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item  ">
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
        <a class="nav-link " href="visteurs.php?page=donnees_utilisateurs&id=<?=$_SESSION['id'] ?>">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-envelope-open" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M8.47 1.318a1 1 0 0 0-.94 0l-6 3.2A1 1 0 0 0 1 5.4v.818l5.724 3.465L8 8.917l1.276.766L15 6.218V5.4a1 1 0 0 0-.53-.882l-6-3.2zM15 7.388l-4.754 2.877L15 13.117v-5.73zm-.035 6.874L8 10.083l-6.965 4.18A1 1 0 0 0 2 15h12a1 1 0 0 0 .965-.738zM1 13.117l4.754-2.852L1 7.387v5.73zM7.059.435a2 2 0 0 1 1.882 0l6 3.2A2 2 0 0 1 16 5.4V14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5.4a2 2 0 0 1 1.059-1.765l6-3.2z"/>
        </svg> Publications 
        </a>
        <a class="nav-link text-dark  " href="visteurs.php?page=publication&id=<?=$_SESSION['id'] ?>">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
        <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        </svg> Publier
        </a>
        <a class="nav-link text-dark  " href="visteurs.php?page=profil&id=<?=$_SESSION['id'] ?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
          </svg> Profil
        </a>
        <a class="nav-link text-dark " href="visteurs.php?page=modifier_utilisateurs&id=<?=$_SESSION['id'] ?>">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zM13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
          </svg> Modifier  profil
        </a>
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
      <a  class="nav-link   " style="font-size:1.2rem"  href="visteurs.php?page=comptabilite&id=<?=$_SESSION['id'] ?>">
      <svg width="1.2rem" height="1.2rem" viewBox="0 0 16 16" class="bi bi-calculator-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
     <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm2 .5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zM4.5 9a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM4 12.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zM7.5 6a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM7 9.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm.5 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM10 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm.5 2.5a.5.5 0 0 0-.5.5v4a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-.5-.5h-1z"/>
     </svg> Comptabilité</a>
     <a   class="nav-link  " style='  font-size:1.2rem'  href="visteurs.php?page=utilisateurs">
      <svg width="1.2rem" height="1.2rem" viewBox="0 0 16 16" class="bi bi-globe" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
     <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4H2.255a7.025 7.025 0 0 1 3.072-2.472 6.7 6.7 0 0 0-.597.933c-.247.464-.462.98-.64 1.539zm-.582 3.5h-2.49c.062-.89.291-1.733.656-2.5H3.82a13.652 13.652 0 0 0-.312 2.5zM4.847 5H7.5v2.5H4.51A12.5 12.5 0 0 1 4.846 5zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5H7.5V11H4.847a12.5 12.5 0 0 1-.338-2.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12H7.5v2.923c-.67-.204-1.335-.82-1.887-1.855A7.97 7.97 0 0 1 5.145 12zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11H1.674a6.958 6.958 0 0 1-.656-2.5h2.49c.03.877.138 1.718.312 2.5zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12h2.355a7.967 7.967 0 0 1-.468 1.068c-.552 1.035-1.218 1.65-1.887 1.855V12zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5h-2.49A13.65 13.65 0 0 0 12.18 5h2.146c.365.767.594 1.61.656 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4H8.5V1.077c.67.204 1.335.82 1.887 1.855.173.324.33.682.468 1.068z"/>
     </svg> Publications <span class="sr-only">(current)</span></a>
     <a href='#' class="nav-link active "style="font-size:1.2rem; color:#A41FDE" >
     <svg width="1.2rem" height="1.2rem" viewBox="0 0 16 16" class="bi bi-globe" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
     <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4H2.255a7.025 7.025 0 0 1 3.072-2.472 6.7 6.7 0 0 0-.597.933c-.247.464-.462.98-.64 1.539zm-.582 3.5h-2.49c.062-.89.291-1.733.656-2.5H3.82a13.652 13.652 0 0 0-.312 2.5zM4.847 5H7.5v2.5H4.51A12.5 12.5 0 0 1 4.846 5zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5H7.5V11H4.847a12.5 12.5 0 0 1-.338-2.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12H7.5v2.923c-.67-.204-1.335-.82-1.887-1.855A7.97 7.97 0 0 1 5.145 12zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11H1.674a6.958 6.958 0 0 1-.656-2.5h2.49c.03.877.138 1.718.312 2.5zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12h2.355a7.967 7.967 0 0 1-.468 1.068c-.552 1.035-1.218 1.65-1.887 1.855V12zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5h-2.49A13.65 13.65 0 0 0 12.18 5h2.146c.365.767.594 1.61.656 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4H8.5V1.077c.67.204 1.335.82 1.887 1.855.173.324.33.682.468 1.068z"/>
     </svg> Articles
    </a>
    </li>
</ul>
</div>
</nav>
</div>
<div class="container">
<div class="col-lg-9">
<div class="card mb-3 shadow-lg p-1 bg-white" >
        <a class="nav-link text-dark " href="visteurs.php?page=autor&id=<?=$reponses['id_utilisateurs'] ?>">
        <div class="card-img bg-light pb-2 pt-2 pl-5" style=' border-radius: 20px;'>
          <?="<img src='".$reponses['images']."' class='images' style='width:1.5rem ; height:1.6rem; border-radius:100px ; '  alt=''>" ;?> 
          <?= $reponses['nom'] ?>
          </div>
          </a>
          </div> 
          <div class="card mb-3 p-1 bg-white" >
          <div class='imagess'>
              <?="<img src='".$reponses['fichier']."' class='card-img '   alt=''>" ;?> 
            </div>
           </div>

           <p class="card-text p-2" style=' text-align: justify;'><?= $reponses['contenu'] ?></p>
           <hr><div class="row ">
           <div class="col-lg-1 "></div>
            <div class="col-lg-2  text-center">
            <div class="card" >
            <a style='text-decoration: none; color:#A41FDE' href="visteurs.php?page=action&t=1&id=<?=$_GET['id'] ?>"><svg width="1.5em"  height="1.5em" viewBox="0 0 16 16" color='#A41FDE' class="bi bi-hand-thumbs-up  mt-2  " fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16v-1c.563 0 .901-.272 1.066-.56a.865.865 0 0 0 .121-.416c0-.12-.035-.165-.04-.17l-.354-.354.353-.354c.202-.201.407-.511.505-.804.104-.312.043-.441-.005-.488l-.353-.354.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581 0-.211-.027-.414-.075-.581-.05-.174-.111-.273-.154-.315L12.793 9l.353-.354c.353-.352.373-.713.267-1.02-.122-.35-.396-.593-.571-.652-.653-.217-1.447-.224-2.11-.164a8.907 8.907 0 0 0-1.094.171l-.014.003-.003.001a.5.5 0 0 1-.595-.643 8.34 8.34 0 0 0 .145-4.726c-.03-.111-.128-.215-.288-.255l-.262-.065c-.306-.077-.642.156-.667.518-.075 1.082-.239 2.15-.482 2.85-.174.502-.603 1.268-1.238 1.977-.637.712-1.519 1.41-2.614 1.708-.394.108-.62.396-.62.65v4.002c0 .26.22.515.553.55 1.293.137 1.936.53 2.491.868l.04.025c.27.164.495.296.776.393.277.095.63.163 1.14.163h3.5v1H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
            </svg>(<?= $likes?>)</a>
            </div>
            </div>
             <div class="col-lg-2   text-center"  style=' border-radius: 20px;'>
             <div class="card">
             <a style='text-decoration: none; color:#A41FDE'  class='' href="visteurs.php?page=action&t=2&id=<?=$_GET['id'] ?>"><svg width="1.5em" color='green' height="1.5em" viewBox="0 0 16 16" class="bi  bi-hand-thumbs-down  mt-2 " fill="currentColor" xmlns="http://www.w3.org/2000/svg">
             <path fill-rule="evenodd" d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28v1c.563 0 .901.272 1.066.56.086.15.121.3.121.416 0 .12-.035.165-.04.17l-.354.353.353.354c.202.202.407.512.505.805.104.312.043.44-.005.488l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.415-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.353.352.373.714.267 1.021-.122.35-.396.593-.571.651-.653.218-1.447.224-2.11.164a8.907 8.907 0 0 1-1.094-.17l-.014-.004H9.62a.5.5 0 0 0-.595.643 8.34 8.34 0 0 1 .145 4.725c-.03.112-.128.215-.288.255l-.262.066c-.306.076-.642-.156-.667-.519-.075-1.081-.239-2.15-.482-2.85-.174-.502-.603-1.267-1.238-1.977C5.597 8.926 4.715 8.23 3.62 7.93 3.226 7.823 3 7.534 3 7.28V3.279c0-.26.22-.515.553-.55 1.293-.138 1.936-.53 2.491-.869l.04-.024c.27-.165.495-.296.776-.393.277-.096.63-.163 1.14-.163h3.5v-1H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z"/>
             </svg>(<?= $dislikes?>)</a>
             </div>
             </div>
             <div style='color:#A41FDE' class="col-lg-4 pt-2 pb-3  text-center"  >
             Commentaire(<?= $commentairesexiste?>)
             </div>
           </div><hr>
     <form action="" method='POST'>
     <div class="row">
     <div class="col-lg-12">
     <div class="form-group row mt-2">
        <label for="inputEmail3" class="col-lg-1 ml-4 col-form-label">
        <?="<img src='".$_SESSION['images']."' class='images' style='width:1.5rem ; height:1.6rem; border-radius:100px ; ' alt=''>" ;?>
         
      </label>
        <div class="col-lg-9">
        <input class="form-control"  style=' border-radius: 20px;'  name="commentaire" type="text" placeholder="Votre commentaire">
        </div>
        <div class="col-lg-1 text-center mt-1 ">
        <button style='border:#D7D7DC'><svg color='#A41FDE' width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-cursor-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103z"/>
        </svg></button>
        </div>
        </div>
        </div>
    </form>
    </div><hr>
     <?php
      while ($commentaires=$commentaire->fetch()) 
      {
        ?>
          
             <div class="row  mr-2 ml-2">
             
               <div class="col-lg-12">
               
                 <div class="form-group row mt-2 pl-2">
                  <label for="inputEmail3" class="col-lg-2 col-form-label">
                  <?="<img src='".$commentaires['images']."' class='images' style='width:1.5rem ; height:1.6rem; border-radius:100px ; ' alt=''>" ;?>
                   <?= $commentaires['nom'] ?>
                    
                </label>
                  <div class="col-lg-10 mt-2">
                  <?= $commentaires['commentaire'] ?>
                 <em> <span style='color:#DCDCD7 ; font-size:14px'><?= $commentaires['date'] ?></span></em>
                  </div>
                  </div>
                 </div>
               </div><hr>
             
      <?php
      }
      ?>
          <h5>
            <a style='color:#A41FDE'  class='pl-2 text-center ' href="visteurs.php?page=Afficher_plus_de_commentaire&id=<?=$get?>">Afficher plus de commentaire</a>
          </h5>
      </div>
      </div>
      </div>
      </div>
      </div>
      <script src="https://kit.fontawesome.com/3d9f317c2d.js" crossorigin="anonymous"></script>
    <script src="../Administration/bootstrap/bootstrap.min.js"></script>
    <script src="../Administration/bootstrap/jquery-3.5.1.js"></script>
</body>
</html>
