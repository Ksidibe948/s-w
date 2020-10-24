<!-- la partie php -->
<?php  
        session_start();
        if (isset($_GET['id'])  AND !empty($_GET['id'])) {
           $getid=htmlspecialchars($_GET['id']);
           $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
           $info=$bdd->prepare('SELECT * FROM administrateurs WHERE id =?');
           $info->execute(array($getid));
           $info_administrateurs=$info->fetch();
          
        } else {
            header('Location:admin.php?page=erreurs');
        }
         
        
?> 
<?php  
         $info=$bdd->prepare("SELECT id, titre,contenu,images,DATE_FORMAT(date,'%d/%m/%y à %Hh%imin%ss') AS date FROM articles WHERE id_administrateurs =?");
         $info->execute(array($getid));?>
<!-- la partie html -->
<!DOCTYPE html>
<html lang="en">
<head>
     <link rel="stylesheet" href="../Administration/css/info_administrateurs.css">
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
      <li class="nav-item active mr-5">
      <a class="nav-link" href="">
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
      <li class="nav-item mr-5">
      <a class="nav-link" href="admin.php?page=publier_articles&id=<?=$_SESSION['id']?>">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cursor-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103z"/>
        </svg>
        Publier des articles
        </a>
      </li>
    </ul>
    <a href="admin.php?page=modification_profil" class="btn btn btn-lg active" role="button" aria-pressed="true">
   <?= $_SESSION['nom'] ?>
   <a href="admin.php?page=deconnexion" class="text-dark">Déconnexion</a>
    </a>

  </div>
</nav>
        <div class="container">
            <br>
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-7">
                <?php
                while( $info_articles=$info->fetch())
                { ?>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="card mb-4">
                            <div class="card-header">
                            <?= "<img src='".$info_administrateurs['images']."'class='images ' style='width:2.5rem;'alt='...'>" ;?>
                            <?= $info_administrateurs['nom'] ?><span class='mr-5'></span><span class='mr-5'></span><span class='ml-5 ti'><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pen" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.707 13.707a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391L10.086 2.5a2 2 0 0 1 2.828 0l.586.586a2 2 0 0 1 0 2.828l-7.793 7.793zM3 11l7.793-7.793a1 1 0 0 1 1.414 0l.586.586a1 1 0 0 1 0 1.414L5 13l-3 1 1-3z"/>
                            <path fill-rule="evenodd" d="M9.854 2.56a.5.5 0 0 0-.708 0L5.854 5.855a.5.5 0 0 1-.708-.708L8.44 1.854a1.5 1.5 0 0 1 2.122 0l.293.292a.5.5 0 0 1-.707.708l-.293-.293z"/>
                            <path d="M13.293 1.207a1 1 0 0 1 1.414 0l.03.03a1 1 0 0 1 .03 1.383L13.5 4 12 2.5l1.293-1.293z"/>
                            </svg> articles</span>  
                            </div>
                            <?= "<img src='".$info_articles['images']."' class='card-img-top' alt='...'>" ;?>
                            <div class="card-body">
                                <h5 class="card-title"> Titre: <?=$info_articles['titre'] ?></h5>
                                <p class="card-text"> <?= substr($info_articles['contenu'],0,100 ) ?>.... <a href="">Lire la suite</a></p>
                                <p class="card-text"><small class="text-muted"><?=$info_articles['date'] ?>  N*:<?=$info_articles['id'] ?></small></p>
                            </div>
                            </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?><br>
              </div>          
            </div>
        </div>
   <script src="../Administration/bootstrap/bootstrap.min.js"></script> 
   <script src="../Administration/bootstrap/jquery-3.5.1.js"></script>
</body>
</html>