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
   $donnees=$bdd->prepare("SELECT publications.contenu,utilisateurs.nom, utilisateurs.images ,DATE_FORMAT(date,  '%d/%m/%Y à %Hh%imin%ss') AS date FROM publications, utilisateurs WHERE publications.id_utilisateurs=utilisateurs.id AND id_publications=?");
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
$count=$bdd->prepare("SELECT  commentaires.id, commentaires.id_publications, commentaires.commentaire,utilisateurs.nom, utilisateurs.images,DATE_FORMAT(date,  '%d/%m/%Y à %Hh%imin%ss') AS date FROM commentaires, utilisateurs WHERE commentaires.id_utilisateurs=utilisateurs.id AND id_publications=? ORDER BY date DESC");
$count->execute(array($_GET['id']));
$commentairesexiste=$count->rowcount();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../site/css/article.css">
    <link rel="stylesheet" href="../Administration/bootstrap/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="banner-area">
        <div class="row">
            <div class="col-lg-12">
            <nav class=" col navbar  navbar-expand-lg navbar-dark bg-success" >
           <a class=" col navbar-brand"  href="#">
        
        <div class='logo text-white mt-1 bg-white '  style='border:solid #A41FDE 2px; width: 50px; text-decoration:underline #A41FDE double;'><span class='logo1' style='padding-left:5px; color:#A41FDE;'>S</span><svg color='#A41FDE'width="1.5em" height="1.5em" color='white' viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
        <path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
        </svg>
          </div>
        </a>
        <ul class="navbar-nav ">
            <li class="nav-item active  mr-3">
              <a class="nav-link" href="visteurs.php?page=utilisateurs"> Publications <span class="sr-only">(current)</span></a>
            </li>
     </ul>
    <ul class="navbar-nav ">
            <li class="nav-item mr-3">
            <a class="nav-link" href="visteurs.php?page=blogs_utilisateurs">blogs
                </a>
            </li>
   </ul>
      <ul class="navbar-nav ">
            <li class="nav-item dropdown mega-area">
            <a class="nav-link  dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Cours
            </a>
            <div class="dropdown-menu  mega-area" aria-labelledby="navbarDropdown">
              <a class="dropdown-item " href="visteurs.php?page=comptabilite&id=<?=$_SESSION['id'] ?>">Comptabilité</a>
              <a class="dropdown-item " href="#">Finances</a>
              <a class="dropdown-item  " href="#">Fiscalité</a>
              <a class="dropdown-item  " href="#">Logistique</a>
              <a class="dropdown-item  " href="#">Marketing</a>
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
            <a class="  btn mr-1 text-white" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>  
            </a>
            <div class="dropdown-menu dropdown-menu-right mt-2 " aria-labelledby="dropdownMenuLink">
            <a class="nav-link text-dark pl-5 " href="visteurs.php?page=publication&id=<?=$_SESSION['id'] ?>">Publier</a>
                <a class="dropdown-item  text-dark pl-5" href="#">SMS</a>
            <a class="nav-link  text-dark pl-5 " href="visteurs.php?page=demande&id=<?=$_SESSION['id'] ?>"> 
            Demande</a>
            </div>
            </div>
        <div class="dropdown">
        <a class=" dropdown-toggle  text-white mr-3" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        </a>
        <div class="dropdown-menu dropdown-menu-right  mt-4 mega-menu " style=' width:200px; ' aria-labelledby="dropdownMenuLink">
        <a class="nav-link text-dark pl-3" href="visteurs.php?page=modifier_utilisateurs&id=<?=$_SESSION['id'] ?>"> Modifier Votre profil</a>
            <div class="dropdown-divider"></div>
            <a class="nav-link text-dark pl-5" href="visteurs.php?page=deconnexion"> 
             <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-folder-symlink-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2l.04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14h10.348a2 2 0 0 0 1.991-1.819l.637-7A2 2 0 0 0 13.81 3zM2.19 3c-.24 0-.47.042-.684.12L1.5 2.98a1 1 0 0 1 1-.98h3.672a1 1 0 0 1 .707.293L7.586 3H2.19zm9.608 5.271l-3.182 1.97c-.27.166-.616-.036-.616-.372V9.1s-2.571-.3-4 2.4c.571-4.8 3.143-4.8 4-4.8v-.769c0-.336.346-.538.616-.371l3.182 1.969c.27.166.27.576 0 .742z"/>
            </svg> Déconnexion</a>
        </div>
        </div>
        </nav>
            </div>
        </div>
    </div>


<div class="row">
  <div class="col-lg-2">
  <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
     <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item pl-5 ">
       <a class="nav-link " href="visteurs.php?page=comptabilite&id=<?=$_SESSION['id'] ?>"><i class="fas fa-calculator"></i>Comptabilité</a>
       <a class="nav-link " href="visteurs.php?page=utilisateurs"><i class="fas fa-globe-africa"></i> Publications <span class="sr-only">(current)</span></a>
       <a class="nav-link " href="visteurs.php?page=les_articles&id=<?=$_GET['id'] ?>"><i class="fas fa-globe-africa"></i> Articles</a>
       <a class="nav-link  active" style='color:#A41FDE;' href=""><i class="fas fa-globe-africa"></i> Commentaires</a>
     
    </li>
    </ul>
  </div>
   </nav>
   </div>

      <div class="col-lg-8  ">
     
           <div class="card w-100 shadow-lg" >
           <a class="nav-link text-dark  " href="visteurs.php?page=autor&id=<?=$_SESSION['id'] ?>">
           <hr><div class="card-text ml-3  pt-2 ">
          <span class=''><?="<img src='".$reponses['images']."' class='coll ' style='width:1.5rem ; height:1.6rem; border-radius:100px ; '  alt=''>" ;?> </span>
           <?= $reponses['nom'] ?>
           </a>
          </div><hr>
             <div class="card-body">
             <span class='card-img ml-2'><?= $reponses['date'] ?></span>
             <p class="card-text" style=' text-align: justify;'><?= $reponses['contenu'] ?></p>
             </div><hr>
             <div class="row mb-2">
             <div class="col-lg-1 "></div>
               <div class="col-lg-3 mr-2 bg-light text-center">
               <a style='text-decoration: none; color:#A41FDE' href="visteurs.php?page=action&t=1&id=<?=$_GET['id'] ?>"><svg width="1.5em"  height="1.5em" viewBox="0 0 16 16" color='#A41FDE' class="bi bi-hand-thumbs-up mb-2 mt-2  ml-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16v-1c.563 0 .901-.272 1.066-.56a.865.865 0 0 0 .121-.416c0-.12-.035-.165-.04-.17l-.354-.354.353-.354c.202-.201.407-.511.505-.804.104-.312.043-.441-.005-.488l-.353-.354.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581 0-.211-.027-.414-.075-.581-.05-.174-.111-.273-.154-.315L12.793 9l.353-.354c.353-.352.373-.713.267-1.02-.122-.35-.396-.593-.571-.652-.653-.217-1.447-.224-2.11-.164a8.907 8.907 0 0 0-1.094.171l-.014.003-.003.001a.5.5 0 0 1-.595-.643 8.34 8.34 0 0 0 .145-4.726c-.03-.111-.128-.215-.288-.255l-.262-.065c-.306-.077-.642.156-.667.518-.075 1.082-.239 2.15-.482 2.85-.174.502-.603 1.268-1.238 1.977-.637.712-1.519 1.41-2.614 1.708-.394.108-.62.396-.62.65v4.002c0 .26.22.515.553.55 1.293.137 1.936.53 2.491.868l.04.025c.27.164.495.296.776.393.277.095.63.163 1.14.163h3.5v1H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                </svg>(<?= $likes?>)</a>
               </div>
               <div class="col-lg-3 mr-2 bg-light  text-center">
               <a style='text-decoration: none; color:#A41FDE'  class='' href="visteurs.php?page=action&t=2&id=<?=$_GET['id'] ?>"><svg width="1.5em" color='green' height="1.5em" viewBox="0 0 16 16" class="bi  bi-hand-thumbs-down mb-2 mt-2 ml-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
               <path fill-rule="evenodd" d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28v1c.563 0 .901.272 1.066.56.086.15.121.3.121.416 0 .12-.035.165-.04.17l-.354.353.353.354c.202.202.407.512.505.805.104.312.043.44-.005.488l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.415-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.353.352.373.714.267 1.021-.122.35-.396.593-.571.651-.653.218-1.447.224-2.11.164a8.907 8.907 0 0 1-1.094-.17l-.014-.004H9.62a.5.5 0 0 0-.595.643 8.34 8.34 0 0 1 .145 4.725c-.03.112-.128.215-.288.255l-.262.066c-.306.076-.642-.156-.667-.519-.075-1.081-.239-2.15-.482-2.85-.174-.502-.603-1.267-1.238-1.977C5.597 8.926 4.715 8.23 3.62 7.93 3.226 7.823 3 7.534 3 7.28V3.279c0-.26.22-.515.553-.55 1.293-.138 1.936-.53 2.491-.869l.04-.024c.27-.165.495-.296.776-.393.277-.096.63-.163 1.14-.163h3.5v-1H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z"/>
                </svg>(<?= $dislikes?>)</a>
               </div>
               <div style='color:#A41FDE' class="col-lg-4 bg-light text-center">
               Commentaire(<?= $commentairesexiste?>)
               </div>
             </div>
           </div>
         </div>
       </div>

      
        
       <form action="" method='POST'>
       <div class="row ml-2 mr-2">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
       <div class="form-group row mt-2">
          <label for="inputEmail3" class="col-lg-2 col-form-label">
          <?="<img src='".$_SESSION['images']."' class='images' style='width:1.5rem ; height:1.6rem; border-radius:100px ; ' alt=''>" ;?>
          Votre commentaire:  
        </label>
          <div class="col-lg-9">
          <input class="form-control"  name="commentaire" type="text" placeholder="Votre commentaire">
          </div>
          <div class="col-lg-1 mt-1 text-center ">
          <button style='border:#D7D7DC'><svg color='#A41FDE' width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-cursor-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103z"/>
          </svg></button>
          </div>
          </div>
         
      </form>
    
     
     
        <div class="row">
          <div class="col-lg-2"></div>
          <div style='color:#A41FDE' class="col-lg-8 text-center mb-3">
                Les nouveaux commentaires
            </div>
            </div> 
  
       <?php
        while ($commentaires=$commentaire->fetch()) 
        {
          ?>
           
               <div class="row mb-2 pl-2">
                 <div class="col-lg-12">
                  
                   <div class="form-group row mt-2">
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
          
        <div class="row">
          
          <div class="col-lg-12 bg-light text-center">
              <a style='color:#A41FDE'  class='pl-2 pb-2 ' href="visteurs.php?page=Afficher_plus_de_commentaire&id=<?=$get?>">Afficher plus de commentaire</a>
              </div>
          </div>
    
           
        </div>
        </div>
     
     
  
    <script src="https://kit.fontawesome.com/3d9f317c2d.js" crossorigin="anonymous"></script>
    <script src="../Administration/bootstrap/bootstrap.min.js"></script>
    <script src="../Administration/bootstrap/jquery-3.5.1.js"></script>
</body>
</html>
