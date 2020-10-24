
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
   $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
   $select=$bdd->query('SELECT * FROM  autres_charges ORDER BY id DESC');
   ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../site/css/utilisation.css">
    <link rel="stylesheet" href="../Administration/bootstrap/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="banner-area">
        <div class="row">
            <div class="col-lg-12">
            <nav class=" col navbar navbar-expand-lg navbar-dark bg-success">
        <a class=" col navbar-brand ml-5"  href="#">
        
        <div class='logo text-warning mt-1'  style='border:solid white 2px; width: 50px; text-decoration:underline double;'><span class='logo1'>S</span><svg width="1.5em" height="1.5em" color='white' viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5H6a.5.5 0 0 1 0-1h3.5V6a.5.5 0 0 1 .5-.5z"/>
        <path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
        </svg>
          </div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbar">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item  mr-3">
              <a class="nav-link" href="visteurs.php?page=charges">Charges<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active  mr-3">
              <a class="nav-link" href="">Autres Charges<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item mr-3">
            <a class="nav-link" href="visteurs.php?page=blogs_utilisateurs">blogs
                </a>
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
            <path fill-rule="evenodd" d="M8 6a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 6z"/>
            </svg>  
            </a>
            <div class="dropdown-menu dropdown-menu-right mt-2 bg-success" aria-labelledby="dropdownMenuLink">
            <a class="nav-link text-white text-center" href="visteurs.php?page=publication&id=<?=$_SESSION['id'] ?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi mr-1 bi-brightness-high" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 1a6 6 0 1 0 0-8 6 6 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.616 1.615a.5.5 0 1 1-.707-.708l1.616-1.616a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.616-1.616a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.616-1.616a.5.5 0 0 1 .707-.707l1.616 1.616a.5.5 0 0 1 0 .707zM6.666 6.665a.5.5 0 0 1-.707 0L2.363 3.05a.5.5 0 1 1 .707-.707l1.616 1.616a.5.5 0 0 1 0 .708z"/>
                </svg>Publier</a>
                <a class="dropdown-item text-white text-center" href="#"> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi mr-1 bi-cursor-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M16.082 2.182a.5.5 0 0 1 .103.557L8.528 15.667a.5.5 0 0 1-.917-.007L5.57 10.696.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103z"/>
            </svg>SMS</a>
            <a class="nav-link text-white text-center" href="visteurs.php?page=demande&id=<?=$_SESSION['id'] ?>"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi mr-1 bi-emoji-smile" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 16zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path fill-rule="evenodd" d="M6.285 9.567a.5.5 0 0 1 .683.183A3.698 3.698 0 0 0 8 11.5a3.698 3.698 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A6.698 6.698 0 0 1 8 12.5a6.698 6.698 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683z"/>
            <path d="M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.668 5 6 5s1 .672 1 1.5zm6 0c0 .828-.668 1.5-1 1.5s-1-.672-1-1.5S9.668 5 10 5s1 .672 1 1.5z"/>
            </svg>Demande</a>
            </div>
            </div>
        <div class="dropdown">
        <a class=" dropdown-toggle  text-warning mr-3" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        </a>
        <div class="dropdown-menu dropdown-menu-right bg-success mt-6 mega-menu " style=' width:200px; ' aria-labelledby="dropdownMenuLink">
        <a class="nav-link text-white text-center" href="visteurs.php?page=modifier_utilisateurs&id=<?=$_SESSION['id'] ?>"> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-gear-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M9.605 1.05c-.613-1.6-2.397-1.6-2.81 0l-.1.36a1.666 1.666 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.666.82.023 1.861-.872 2.105l-.36.1c-1.6.613-1.6 2.397 0 2.81l.36.1a1.666 1.666 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.666 1.666 0 0 1 2.105.872l.1.36c.613 1.6 2.397 1.6 2.81 0l.1-.36a1.666 1.666 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.666 1.666 0 0 1 .872-2.105l.36-.1c1.6-.613 1.6-2.397 0-2.81l-.36-.1a1.666 1.666 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.666 1.666 0 0 1-2.105-.872l-.1-.36zM8 10.93a2.929 2.929 0 1 0 0-5.86 2.929 2.929 0 0 0 0 5.858z"/>
            </svg> Modifier Votre profil</a>
            <div class="dropdown-divider"></div>
            <a class="nav-link text-white text-center" href="visteurs.php?page=deconnexion"> 
             <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-folder-symlink-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M13.81 3H9.828a2 2 0 0 1-1.616-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2l.06.87a1.99 1.99 0 0 0-.362 1.311l.637 7A2 2 0 0 0 2.826 16h10.368a2 2 0 0 0 1.991-1.819l.637-7A2 2 0 0 0 13.81 3zM2.19 3c-.26 0-.67.062-.686.12L1.5 2.98a1 1 0 0 1 1-.98h3.672a1 1 0 0 1 .707.293L7.586 3H2.19zm9.608 5.271l-3.182 1.97c-.27.166-.616-.036-.616-.372V9.1s-2.571-.3-6 2.6c.571-6.8 3.163-6.8 6-6.8v-.769c0-.336.366-.538.616-.371l3.182 1.969c.27.166.27.576 0 .762z"/>
            </svg> Déconnexion</a>
        </div>
        </div>
        </div>
        </nav>
            </div>
        </div>
    </div>
    <div class="container">
    <div class="jumbotron jumbotron-fluid">
        <div class="container text-center">
       
      <h1 class="display-4">La liste des autre Charges! </h1>
       <h6></h6>
      <h4> <a style='' href="visteurs.php?page=nouvelle_charge&id=<?=$_SESSION['id'] ?>">Enregistre une nouvelle Charge</a></h4>
       </div>
      </div>
     <?php
     
        while($resultat=$select->fetch())
        { 
            $montant_tva=$resultat['montant_th']*$resultat['taux_tva']/100;
            $montant_ttc= $montant_tva+$resultat['montant_th'];
            $reste=$montant_ttc-$resultat['montant_payer'];
            ?>
            
            <div class="row mb-2">
            <div class="col-lg-12">
            <div class="card shadow-lg w-100">
            <div class="row ">
              <div class="col-lg-12"></div>
              <div class="col-lg-10 "></div>
            <div class="col-lg-2 ">
            <ul style=" list-style: none;">
            <li class="nav-item dropdown mega-area">
            <a class="nav-link  dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            </a>
            <div class="dropdown-menu dropdown-menu-right  bg-success mega-area" aria-labelledby="navbarDropdown">
              <a style='margin-left:15px ;color: white;' href="visteurs.php?page=modifier_autre_charges&id=<?=$resultat['id'] ?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pen" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
             <path fill-rule="evenodd" d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
             </svg> Modifier</a><br>
             <a style='margin-left:15px ;color: white;' href="visteurs.php?page=journal_autre_charge&id=<?=$resultat['id'] ?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pen" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
             <path fill-rule="evenodd" d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
             </svg>Journal</a><br>
             <a style='margin-left:15px; color:WHITE' href="visteurs.php?page=supprimer_autre_charges&id=<?=$resultat['id'] ?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg> Supprimer</a>
            </div>
            </li>
            </ul>
            </div>
            </div><hr>
              <div class="row ml-5 mr-5">
              <div class="col-lg-2 text-center"style='border:solid black 1px'>
                <h6>Nom de l'opération </h6>
              </div>
              <div class="col-lg-2 text-center"style='border:solid black 1px'>
                <h6>Montant HT</h6>
              </div>
              <div class="col-lg-2 text-center"style='border:solid black 1px'>
               <h6>TVA</h6>
              </div>
              <div class="col-lg-2 text-center"style='border:solid black 1px'>
                <h6>Montant payer</h6>
                <p> banque N° (<?=  $resultat['numero_banque'] ?>)</p>
              </div>
              <div class="col-lg-2 text-center"style='border:solid black 1px'>
               <h6>Montant TTC</h6>
              </div>
              <?php
               if ($montant_ttc>$resultat['montant_payer']) {
                    ?>
                <div class="col-lg-2 text-center"style='border:solid black 1px'>
                <h6>Montant à payer</h6>
               </div>
               <?php
               }else {
                  ?>
                   <div class="col-lg-2 text-center"style='border:solid black 1px'>
                <h6>Reste à Recuperer</h6>
               </div>
                  <?php
               }
              ?>
              </div>

              <div class="row ml-5 mr-5">
                  <div class="col-lg-2 text-center"style='border:solid black 1px'>
              <?= $resultat['nom_operation'] ?>
              </div>
              
              <div class="col-lg-2 text-center"style='border:solid black 1px'>
              <?= $resultat['montant_th'] ?>
              </div>
              <div class="col-lg-2 text-center"style='border:solid black 1px'>
              <?php
              
              echo ($resultat['taux_tva']).'%'.'<br>';  
               echo  $montant_tva?>dh
              </div>
              <div class="col-lg-2 text-center"style='border:solid black 1px'>
              <?= $resultat['montant_payer'] ?>
              </div>
              <div class="col-lg-2 text-center"style='border:solid black 1px'>
              <?= $montant_ttc
              
               ?>dh
              </div>
              <?php
               if ($montant_ttc>$resultat['montant_th']) {
                    ?>
                <div class="col-lg-2 text-center"style='border:solid black 1px'>
                <h6><?= $reste?></h6>
               </div>
               <?php
               }else {
                  ?>
                   <div class="col-lg-2 text-center"style='border:solid black 1px'>
                   <h6><?= $reste?></h6>
               </div>
                  <?php
               }
              ?>
              </div><hr>
              </div>
              </div>
              </div>
              
            <?php
        }
        ?>
        
    <script src="../Administration/bootstrap/bootstrap.min.js"></script>
    <script src="../Administration/bootstrap/jquery-3.5.1.js"></script>
</body>
</html>
