
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
if (isset($_GET['id'])) {
    $getid=$_GET['id'];
}
   $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
   $select=$bdd->prepare("SELECT * FROM stoks_materiels 
 WHERE  id=? ");
   $select->execute(array($getid));
   $donnees=$select->fetch();
 ?>
      <?php
         $cent='100';
         $dureeS='';
        $montant=$donnees['quantiteS']*$donnees['prixS'];
        $reductions=$donnees['taux_reductionS']/100;
        $montant_reduction=$montant*$reductions;
        $net_commercial=$montant-$montant_reduction;
         $EXOMPTE=$donnees['taux_exompteS']/100;
         $montant_exompte=$net_commercial*$EXOMPTE;
         $net_financier=$net_commercial-$montant_exompte;
         $montant_ht=$net_financier+$donnees['montant_transportS'];
         $TVA=$donnees['taux_tvaS']/100;
         $montant_tva=$montant_ht*$TVA;
         $montant_ttc=$montant_tva+$montant_ht;
         $net_à_payer=$montant_ttc+$donnees['montant_emballageS']-$donnees['montant_avanceS'];
         $reste=$net_à_payer-$donnees['montant_payement'];
         $cout_acquisition= $montant_ht+$donnees['montant_emballageS']+$donnees['frais_accessoireS']-$donnees['montant_avanceS'];
       
        $dureeS= $donnees['dureeS'];
        if( $dureeS > 0)
        {
            $taux_amortissement = 100/$dureeS ;
        }else {
            $taux_amortissement = 100/1 ;
        }
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
            <div class="col-12">
            <nav class=" col navbar navbar-expand-lg navbar-dark bg-success">
        <a class=" col navbar-brand "  href="#">
        
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
              <a class="nav-link" href="visteurs.php?page=achat_immobilisation">factures achat Materièl<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active  mr-3">
              <a class="nav-link" href="">Amortissement<span class="sr-only">(current)</span></a>
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
            <div class="dropdown-menu dropdown-menu-right mt-12bg-success" aria-labelledby="dropdownMenuLink">
            <a class="nav-link text-white " href="visteurs.php?page=publication&id=<?=$_SESSION['id'] ?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi mr-1 bi-brightness-high" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 1a6 6 0 1 0 0-8 6 6 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.616 1.615a.5.5 0 1 1-.707-.708l1.616-1.616a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.616-1.616a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.616-1.616a.5.5 0 0 1 .707-.707l1.616 1.616a.5.5 0 0 1 0 .707zM6.666 6.665a.5.5 0 0 1-.707 0L2.363 3.05a.5.5 0 1 1 .707-.707l1.616 1.616a.5.5 0 0 1 0 .708z"/>
                </svg>Publier</a>
                <a class="dropdown-item text-white " href="#"> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi mr-1 bi-cursor-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M16.08122.182a.5.5 0 0 1 .103.557L8.528 15.667a.5.5 0 0 1-.917-.007L5.57 10.696.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103z"/>
            </svg>SMS</a>
            <a class="nav-link text-white " href="visteurs.php?page=demande&id=<?=$_SESSION['id'] ?>"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi mr-1 bi-emoji-smile" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 16zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path fill-rule="evenodd" d="M6.285 9.567a.5.5 0 0 1 .683.183A3.698 3.698 0 0 0 8 11.5a3.698 3.698 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A6.698 6.698 0 0 1 8 12.5a6.698 6.698 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683z"/>
            <path d="M7 6.5C7 7.328 6.55128 6 8s-1-.672-1-1.5S5.668 5 6 5s1 .67121 1.5zm6 0c0 .828-.668 1.5-1 1.5s-1-.672-1-1.5S9.668 5 10 5s1 .67121 1.5z"/>
            </svg>Demande</a>
            </div>
            </div>
        <div class="dropdown">
        <a class=" dropdown-toggle  text-warning mr-3" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        </a>
        <div class="dropdown-menu dropdown-menu-right bg-success mt-6 mega-menu " style=' width:200px; ' aria-labelledby="dropdownMenuLink">
        <a class="nav-link text-white " href="visteurs.php?page=modifier_utilisateurs&id=<?=$_SESSION['id'] ?>"> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-gear-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M9.605 1.05c-.613-1.6-2.397-1.6-2.81 0l-.1.36a1.666 1.666 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.666.82.023 1.861-.87122.105l-.36.1c-1.6.613-1.6 2.397 0 2.81l.36.1a1.666 1.666 0 0 1 .87122.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.666 1.666 0 0 1 2.105.872l.1.36c.613 1.6 2.397 1.6 2.81 0l.1-.36a1.666 1.666 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.666 1.666 0 0 1 .872-2.105l.36-.1c1.6-.613 1.6-2.397 0-2.81l-.36-.1a1.666 1.666 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.666 1.666 0 0 1-2.105-.872l-.1-.36zM8 10.93a2.929 2.929 0 1 0 0-5.86 2.929 2.929 0 0 0 0 5.858z"/>
            </svg> Modifier Votre profil</a>
            <div class="dropdown-divider"></div>
            <a class="nav-link text-white " href="visteurs.php?page=deconnexion"> 
             <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-folder-symlink-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M13.81 3H9.828a12120 0 1-1.616-.586l-.828-.828A12120 0 0 6.17121H2.5a12120 0 0-122l.06.87a1.99 1.99 0 0 0-.36121.311l.637 7A12120 0 0 2.826 16h10.368a12120 0 0 1.991-1.819l.637-7A12120 0 0 13.81 3zM2.19 3c-.26 0-.67.062-.686.12L1.5 2.98a1 1 0 0 1 1-.98h3.672a1 1 0 0 1 .707.293L7.586 3H2.19zm9.608 5.271l-3.18121.97c-.27.166-.616-.036-.616-.372V9.1s-2.571-.3-6 2.6c.571-6.8 3.163-6.8 6-6.8v-.769c0-.336.366-.538.616-.371l3.18121.969c.27.166.27.576 0 .762z"/>
            </svg> Déconnexion</a>
        </div>
        </div>
        </div>
        </nav>
            </div>
        </div>
    </div> 
    <div class="container">
    <div class="col-lg-12">
    <?php
    if ($donnees['dureeS']==1 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;
            $annuite2=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;

            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                     <hr><div class="row ">
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div><hr>
        
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?> 
            
    <?php
    if ($donnees['dureeS']==2 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;
            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
         
    

            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
      


     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
        
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>  
            
    <?php
    if ($donnees['dureeS']==3 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;
            
            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
    
            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            


     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 <div class="card shadow-lg w-100 pb-5 pl-4">

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?> 
           
    <?php
    if ($donnees['dureeS']==4 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;


            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;


     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div><hr>

                   
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>

            
<?php
    if ($donnees['dureeS']==5 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;


            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition-$annuite_cumule_6;


     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                         
                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>

                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div><br>

                   
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
            
    <?php
    if ($donnees['dureeS']==6 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;

       
            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition - $annuite_cumule_7;

     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>       
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div><br>
                   
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
    <?php
    if ($donnees['dureeS']==7 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement/100;
            $annuite8=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;
            $annuite_cumule_8=$annuite_cumule_7+$annuite8;

            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition-$annuite_cumule_7;
            $vnc8=$cout_acquisition-$annuite_cumule_8;
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>
                     <div class="row">
                     <div >
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>        
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div> 
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                     </div> <hr>
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
                             
    
    <?php
    if ($donnees['dureeS']==8 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement/100;
            $annuite8=$cout_acquisition*$taux_amortissement/100;
            $annuite9=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;
            $annuite_cumule_8=$annuite_cumule_7+$annuite8;
            $annuite_cumule_9=$annuite_cumule_8+$annuite9;

            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition-$annuite_cumule_7;
            $vnc8=$cout_acquisition-$annuite_cumule_8;
            $vnc9=$cout_acquisition-$annuite_cumule_9;

     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                     </div><hr>
            
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
                      
    
    <?php
    if ($donnees['dureeS']==9 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement/100;
            $annuite8=$cout_acquisition*$taux_amortissement/100;
            $annuite9=$cout_acquisition*$taux_amortissement/100;
            $annuite10=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;
            $annuite_cumule_8=$annuite_cumule_7+$annuite8;

            $annuite_cumule_9=$annuite_cumule_8+$annuite9;
            $annuite_cumule_10=$annuite_cumule_9+$annuite10;

            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition-$annuite_cumule_7;
            $vnc8=$cout_acquisition-$annuite_cumule_8;
            $vnc9=$cout_acquisition-$annuite_cumule_9;
            $vnc10=$cout_acquisition-$annuite_cumule_10;

       
    
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                     </div>

                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                     </div><hr>
                  
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
    
                   
    
    <?php
    if ($donnees['dureeS']==10 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement/100;
            $annuite8=$cout_acquisition*$taux_amortissement/100;
            $annuite9=$cout_acquisition*$taux_amortissement/100;
            $annuite10=$cout_acquisition*$taux_amortissement/100;
            $annuite11=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;
            $annuite_cumule_8=$annuite_cumule_7+$annuite8;

            $annuite_cumule_9=$annuite_cumule_8+$annuite9;
            $annuite_cumule_10=$annuite_cumule_9+$annuite10;
            $annuite_cumule_11=$annuite_cumule_10+$annuite11;

            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition-$annuite_cumule_7;
            $vnc8=$cout_acquisition-$annuite_cumule_8;
            $vnc9=$cout_acquisition-$annuite_cumule_9;
            $vnc10=$cout_acquisition-$annuite_cumule_10;
            $vnc11=$cout_acquisition-$annuite_cumule_11;
       
    
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                     </div>
                                        
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                     </div><hr>

                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
   
                  
    
    <?php
    if ($donnees['dureeS']==11 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement/100;
            $annuite8=$cout_acquisition*$taux_amortissement/100;
            $annuite9=$cout_acquisition*$taux_amortissement/100;

            $annuite10=$cout_acquisition*$taux_amortissement/100;
            $annuite11=$cout_acquisition*$taux_amortissement/100;
            $annuite12=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;
            $annuite_cumule_8=$annuite_cumule_7+$annuite8;

            $annuite_cumule_9=$annuite_cumule_8+$annuite9;
            $annuite_cumule_10=$annuite_cumule_9+$annuite10;
            $annuite_cumule_11=$annuite_cumule_10+$annuite11;
            $annuite_cumule_12=$annuite_cumule_11+$annuite12;

            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition-$annuite_cumule_7;
            $vnc8=$cout_acquisition-$annuite_cumule_8;
            $vnc9=$cout_acquisition-$annuite_cumule_9;
            $vnc10=$cout_acquisition-$annuite_cumule_10;
            $vnc11=$cout_acquisition-$annuite_cumule_11;
            $vnc12=$cout_acquisition - $annuite_cumule_12;




    
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                     </div><hr>
                    
               
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
    
      
    
    <?php
    if ($donnees['dureeS']==12 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement/100;
            $annuite8=$cout_acquisition*$taux_amortissement/100;
            $annuite9=$cout_acquisition*$taux_amortissement/100;

            $annuite10=$cout_acquisition*$taux_amortissement/100;
            $annuite11=$cout_acquisition*$taux_amortissement/100;
            $annuite12=$cout_acquisition*$taux_amortissement/100;
            $annuite13=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;
            $annuite_cumule_8=$annuite_cumule_7+$annuite8;

            $annuite_cumule_9=$annuite_cumule_8+$annuite9;
            $annuite_cumule_10=$annuite_cumule_9+$annuite10;
            $annuite_cumule_11=$annuite_cumule_10+$annuite11;
            $annuite_cumule_12=$annuite_cumule_11+$annuite12;
            $annuite_cumule_13=$annuite_cumule_12+$annuite13;

            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition-$annuite_cumule_7;
            $vnc8=$cout_acquisition-$annuite_cumule_8;
            $vnc9=$cout_acquisition-$annuite_cumule_9;
            $vnc10=$cout_acquisition-$annuite_cumule_10;
            $vnc11=$cout_acquisition-$annuite_cumule_11;
            $vnc12=$cout_acquisition - $annuite_cumule_12;
            $vnc13=$cout_acquisition-$annuite_cumule_13;



    
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                     </div><hr>
            
               
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
    
    
    
    <?php
    if ($donnees['dureeS']==13 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement/100;
            $annuite8=$cout_acquisition*$taux_amortissement/100;
            $annuite9=$cout_acquisition*$taux_amortissement/100;

            $annuite10=$cout_acquisition*$taux_amortissement/100;
            $annuite11=$cout_acquisition*$taux_amortissement/100;
            $annuite12=$cout_acquisition*$taux_amortissement/100;
            $annuite13=$cout_acquisition*$taux_amortissement/100;
            $annuite14=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;
            $annuite_cumule_8=$annuite_cumule_7+$annuite8;

            $annuite_cumule_9=$annuite_cumule_8+$annuite9;
            $annuite_cumule_10=$annuite_cumule_9+$annuite10;
            $annuite_cumule_11=$annuite_cumule_10+$annuite11;
            $annuite_cumule_12=$annuite_cumule_11+$annuite12;
            $annuite_cumule_13=$annuite_cumule_12+$annuite13;
            $annuite_cumule_14=$annuite_cumule_13+$annuite14;

            
        
  

  



            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition-$annuite_cumule_7;
            $vnc8=$cout_acquisition-$annuite_cumule_8;
            $vnc9=$cout_acquisition-$annuite_cumule_9;
            $vnc10=$cout_acquisition-$annuite_cumule_10;
            $vnc11=$cout_acquisition-$annuite_cumule_11;
            $vnc12=$cout_acquisition - $annuite_cumule_12;
            $vnc13=$cout_acquisition-$annuite_cumule_13;
            $vnc14=$cout_acquisition-$annuite_cumule_14;


    
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                     </div><hr>
               
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
    
    
    <?php
    if ($donnees['dureeS']==14 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement/100;
            $annuite8=$cout_acquisition*$taux_amortissement/100;
            $annuite9=$cout_acquisition*$taux_amortissement/100;

            $annuite10=$cout_acquisition*$taux_amortissement/100;
            $annuite11=$cout_acquisition*$taux_amortissement/100;
            $annuite12=$cout_acquisition*$taux_amortissement/100;
            $annuite13=$cout_acquisition*$taux_amortissement/100;
            $annuite14=$cout_acquisition*$taux_amortissement/100;
            $annuite15=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;
            $annuite_cumule_8=$annuite_cumule_7+$annuite8;

            $annuite_cumule_9=$annuite_cumule_8+$annuite9;
            $annuite_cumule_10=$annuite_cumule_9+$annuite10;
            $annuite_cumule_11=$annuite_cumule_10+$annuite11;
            $annuite_cumule_12=$annuite_cumule_11+$annuite12;
            $annuite_cumule_13=$annuite_cumule_12+$annuite13;
            $annuite_cumule_14=$annuite_cumule_13+$annuite14;
            $annuite_cumule_15=$annuite_cumule_14+$annuite15;
            
        
  

  



            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition-$annuite_cumule_7;
            $vnc8=$cout_acquisition-$annuite_cumule_8;
            $vnc9=$cout_acquisition-$annuite_cumule_9;
            $vnc10=$cout_acquisition-$annuite_cumule_10;
            $vnc11=$cout_acquisition-$annuite_cumule_11;
            $vnc12=$cout_acquisition - $annuite_cumule_12;
            

            $vnc13=$cout_acquisition-$annuite_cumule_13;
            $vnc14=$cout_acquisition-$annuite_cumule_14;
            $vnc15=$cout_acquisition-$annuite_cumule_15;

    
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             15ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc15?> </h6>
                         </div>
                     </div><hr>
                 
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
    
    
    <?php
    if ($donnees['dureeS']==15 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement/100;
            $annuite8=$cout_acquisition*$taux_amortissement/100;
            $annuite9=$cout_acquisition*$taux_amortissement/100;

            $annuite10=$cout_acquisition*$taux_amortissement/100;
            $annuite11=$cout_acquisition*$taux_amortissement/100;
            $annuite12=$cout_acquisition*$taux_amortissement/100;
            $annuite13=$cout_acquisition*$taux_amortissement/100;
            $annuite14=$cout_acquisition*$taux_amortissement/100;
            $annuite15=$cout_acquisition*$taux_amortissement/100;
            $annuite16=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;
            $annuite_cumule_8=$annuite_cumule_7+$annuite8;

            $annuite_cumule_9=$annuite_cumule_8+$annuite9;
            $annuite_cumule_10=$annuite_cumule_9+$annuite10;
            $annuite_cumule_11=$annuite_cumule_10+$annuite11;
            $annuite_cumule_12=$annuite_cumule_11+$annuite12;
            $annuite_cumule_13=$annuite_cumule_12+$annuite13;
            $annuite_cumule_14=$annuite_cumule_13+$annuite14;
            $annuite_cumule_15=$annuite_cumule_14+$annuite15;
            
            $annuite_cumule_16=$annuite_cumule_15+$annuite16;
  

  



            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition-$annuite_cumule_7;
            $vnc8=$cout_acquisition-$annuite_cumule_8;
            $vnc9=$cout_acquisition-$annuite_cumule_9;
            $vnc10=$cout_acquisition-$annuite_cumule_10;
            $vnc11=$cout_acquisition-$annuite_cumule_11;
            $vnc12=$cout_acquisition - $annuite_cumule_12;
            

            $vnc13=$cout_acquisition-$annuite_cumule_13;
            $vnc14=$cout_acquisition-$annuite_cumule_14;
            $vnc15=$cout_acquisition-$annuite_cumule_15;
            $vnc16=$cout_acquisition-$annuite_cumule_16;
      


            
    
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             15ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc15?> </h6>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             16ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc16?> </h6>
                         </div>
                     </div><hr>

                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
    
    <?php
    if ($donnees['dureeS']==16 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement/100;
            $annuite8=$cout_acquisition*$taux_amortissement/100;
            $annuite9=$cout_acquisition*$taux_amortissement/100;

            $annuite10=$cout_acquisition*$taux_amortissement/100;
            $annuite11=$cout_acquisition*$taux_amortissement/100;
            $annuite12=$cout_acquisition*$taux_amortissement/100;
            $annuite13=$cout_acquisition*$taux_amortissement/100;
            $annuite14=$cout_acquisition*$taux_amortissement/100;
            $annuite15=$cout_acquisition*$taux_amortissement/100;
            $annuite16=$cout_acquisition*$taux_amortissement/100;
            $annuite17=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;
            $annuite_cumule_8=$annuite_cumule_7+$annuite8;

            $annuite_cumule_9=$annuite_cumule_8+$annuite9;
            $annuite_cumule_10=$annuite_cumule_9+$annuite10;
            $annuite_cumule_11=$annuite_cumule_10+$annuite11;
            $annuite_cumule_12=$annuite_cumule_11+$annuite12;
            $annuite_cumule_13=$annuite_cumule_12+$annuite13;
            $annuite_cumule_14=$annuite_cumule_13+$annuite14;
            $annuite_cumule_15=$annuite_cumule_14+$annuite15;
            
            $annuite_cumule_16=$annuite_cumule_15+$annuite16;
            $annuite_cumule_17=$annuite_cumule_16+$annuite17;

  



            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition-$annuite_cumule_7;
            $vnc8=$cout_acquisition-$annuite_cumule_8;
            $vnc9=$cout_acquisition-$annuite_cumule_9;
            $vnc10=$cout_acquisition-$annuite_cumule_10;
            $vnc11=$cout_acquisition-$annuite_cumule_11;
            $vnc12=$cout_acquisition - $annuite_cumule_12;
            

            $vnc13=$cout_acquisition-$annuite_cumule_13;
            $vnc14=$cout_acquisition-$annuite_cumule_14;
            $vnc15=$cout_acquisition-$annuite_cumule_15;
            $vnc16=$cout_acquisition-$annuite_cumule_16;
            $vnc17=$cout_acquisition-$annuite_cumule_17;


            
    
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             15ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc15?> </h6>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             16ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc16?> </h6>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             17ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc17?> </h6>
                         </div>
                     </div><hr>
                
                 
                    
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
 
    
    <?php
    if ($donnees['dureeS']==17 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement/100;
            $annuite8=$cout_acquisition*$taux_amortissement/100;
            $annuite9=$cout_acquisition*$taux_amortissement/100;

            $annuite10=$cout_acquisition*$taux_amortissement/100;
            $annuite11=$cout_acquisition*$taux_amortissement/100;
            $annuite12=$cout_acquisition*$taux_amortissement/100;
            $annuite13=$cout_acquisition*$taux_amortissement/100;
            $annuite14=$cout_acquisition*$taux_amortissement/100;
            $annuite15=$cout_acquisition*$taux_amortissement/100;
            $annuite16=$cout_acquisition*$taux_amortissement/100;
            $annuite17=$cout_acquisition*$taux_amortissement/100;
            $annuite18=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;
            $annuite_cumule_8=$annuite_cumule_7+$annuite8;

            $annuite_cumule_9=$annuite_cumule_8+$annuite9;
            $annuite_cumule_10=$annuite_cumule_9+$annuite10;
            $annuite_cumule_11=$annuite_cumule_10+$annuite11;
            $annuite_cumule_12=$annuite_cumule_11+$annuite12;
            $annuite_cumule_13=$annuite_cumule_12+$annuite13;
            $annuite_cumule_14=$annuite_cumule_13+$annuite14;
            $annuite_cumule_15=$annuite_cumule_14+$annuite15;
            
            $annuite_cumule_16=$annuite_cumule_15+$annuite16;
            $annuite_cumule_17=$annuite_cumule_16+$annuite17;
            $annuite_cumule_18=$annuite_cumule_17+$annuite18;
    
  



            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition-$annuite_cumule_7;
            $vnc8=$cout_acquisition-$annuite_cumule_8;
            $vnc9=$cout_acquisition-$annuite_cumule_9;
            $vnc10=$cout_acquisition-$annuite_cumule_10;
            $vnc11=$cout_acquisition-$annuite_cumule_11;
            $vnc12=$cout_acquisition - $annuite_cumule_12;
            

            $vnc13=$cout_acquisition-$annuite_cumule_13;
            $vnc14=$cout_acquisition-$annuite_cumule_14;
            $vnc15=$cout_acquisition-$annuite_cumule_15;
            $vnc16=$cout_acquisition-$annuite_cumule_16;
            $vnc17=$cout_acquisition-$annuite_cumule_17;
            $vnc18=$cout_acquisition - $annuite_cumule_18;
 
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             15ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc15?> </h6>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             16ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc16?> </h6>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             17ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc17?> </h6>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             18ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc18?> </h6>
                         </div>
                     </div><hr>
             
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
 
    
    <?php
    if ($donnees['dureeS']==18 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement/100;
            $annuite8=$cout_acquisition*$taux_amortissement/100;
            $annuite9=$cout_acquisition*$taux_amortissement/100;

            $annuite10=$cout_acquisition*$taux_amortissement/100;
            $annuite11=$cout_acquisition*$taux_amortissement/100;
            $annuite12=$cout_acquisition*$taux_amortissement/100;
            $annuite13=$cout_acquisition*$taux_amortissement/100;
            $annuite14=$cout_acquisition*$taux_amortissement/100;
            $annuite15=$cout_acquisition*$taux_amortissement/100;
            $annuite16=$cout_acquisition*$taux_amortissement/100;
            $annuite17=$cout_acquisition*$taux_amortissement/100;
            $annuite18=$cout_acquisition*$taux_amortissement/100;
            $annuite19=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;
            $annuite_cumule_8=$annuite_cumule_7+$annuite8;

            $annuite_cumule_9=$annuite_cumule_8+$annuite9;
            $annuite_cumule_10=$annuite_cumule_9+$annuite10;
            $annuite_cumule_11=$annuite_cumule_10+$annuite11;
            $annuite_cumule_12=$annuite_cumule_11+$annuite12;
            $annuite_cumule_13=$annuite_cumule_12+$annuite13;
            $annuite_cumule_14=$annuite_cumule_13+$annuite14;
            $annuite_cumule_15=$annuite_cumule_14+$annuite15;
            
            $annuite_cumule_16=$annuite_cumule_15+$annuite16;
            $annuite_cumule_17=$annuite_cumule_16+$annuite17;
            $annuite_cumule_18=$annuite_cumule_17+$annuite18;
            $annuite_cumule_19=$annuite_cumule_18+$annuite19;
  



            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition-$annuite_cumule_7;
            $vnc8=$cout_acquisition-$annuite_cumule_8;
            $vnc9=$cout_acquisition-$annuite_cumule_9;
            $vnc10=$cout_acquisition-$annuite_cumule_10;
            $vnc11=$cout_acquisition-$annuite_cumule_11;
            $vnc12=$cout_acquisition - $annuite_cumule_12;
            

            $vnc13=$cout_acquisition-$annuite_cumule_13;
            $vnc14=$cout_acquisition-$annuite_cumule_14;
            $vnc15=$cout_acquisition-$annuite_cumule_15;
            $vnc16=$cout_acquisition-$annuite_cumule_16;
            $vnc17=$cout_acquisition-$annuite_cumule_17;
            $vnc18=$cout_acquisition - $annuite_cumule_18;
            $vnc19=$cout_acquisition - $annuite_cumule_19;

            
    
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             15ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc15?> </h6>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             16ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc16?> </h6>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             17ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc17?> </h6>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             18ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc18?> </h6>
                         </div>
                     </div><hr>
                                                           
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             19ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite19?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_19?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc19?> </h6>
                         </div>
                     </div><hr>
                 
                 
                    
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
 
    <?php
    if ($donnees['dureeS']==19 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement/100;
            $annuite8=$cout_acquisition*$taux_amortissement/100;
            $annuite9=$cout_acquisition*$taux_amortissement/100;

            $annuite10=$cout_acquisition*$taux_amortissement/100;
            $annuite11=$cout_acquisition*$taux_amortissement/100;
            $annuite12=$cout_acquisition*$taux_amortissement/100;
            $annuite13=$cout_acquisition*$taux_amortissement/100;
            $annuite14=$cout_acquisition*$taux_amortissement/100;
            $annuite15=$cout_acquisition*$taux_amortissement/100;
            $annuite16=$cout_acquisition*$taux_amortissement/100;
            $annuite17=$cout_acquisition*$taux_amortissement/100;
            $annuite18=$cout_acquisition*$taux_amortissement/100;
            $annuite19=$cout_acquisition*$taux_amortissement/100;
            $annuite20=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;
            $annuite_cumule_8=$annuite_cumule_7+$annuite8;

            $annuite_cumule_9=$annuite_cumule_8+$annuite9;
            $annuite_cumule_10=$annuite_cumule_9+$annuite10;
            $annuite_cumule_11=$annuite_cumule_10+$annuite11;
            $annuite_cumule_12=$annuite_cumule_11+$annuite12;
            $annuite_cumule_13=$annuite_cumule_12+$annuite13;
            $annuite_cumule_14=$annuite_cumule_13+$annuite14;
            $annuite_cumule_15=$annuite_cumule_14+$annuite15;
            
            $annuite_cumule_16=$annuite_cumule_15+$annuite16;
            $annuite_cumule_17=$annuite_cumule_16+$annuite17;
            $annuite_cumule_18=$annuite_cumule_17+$annuite18;
            $annuite_cumule_19=$annuite_cumule_18+$annuite19;
            $annuite_cumule_20=$annuite_cumule_19+$annuite20;



            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition-$annuite_cumule_7;
            $vnc8=$cout_acquisition-$annuite_cumule_8;
            $vnc9=$cout_acquisition-$annuite_cumule_9;
            $vnc10=$cout_acquisition-$annuite_cumule_10;
            $vnc11=$cout_acquisition-$annuite_cumule_11;
            $vnc12=$cout_acquisition - $annuite_cumule_12;
            

            $vnc13=$cout_acquisition-$annuite_cumule_13;
            $vnc14=$cout_acquisition-$annuite_cumule_14;
            $vnc15=$cout_acquisition-$annuite_cumule_15;
            $vnc16=$cout_acquisition-$annuite_cumule_16;
            $vnc17=$cout_acquisition-$annuite_cumule_17;
            $vnc18=$cout_acquisition - $annuite_cumule_18;
            $vnc19=$cout_acquisition-$annuite_cumule_19;
            $vnc20=$cout_acquisition-$annuite_cumule_20;
            
    
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             15ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc15?> </h6>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             16ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc16?> </h6>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             17ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc17?> </h6>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             18ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc18?> </h6>
                         </div>
                     </div>
                                                                
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             19ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite19?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_19?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc19?> </h6>
                         </div>
                     </div>
                                                            
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             20ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite20?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_20?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc20?> </h6>
                         </div>
                     </div><hr>
                    
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>

    <?php
    if ($donnees['dureeS']==20 AND $donnees['systemeS']=='Lineaire') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }
            $annuite=$cout_acquisition*$taux_amortissement*$a1/1200;

            $annuite2=$cout_acquisition*$taux_amortissement/100;
            $annuite3=$cout_acquisition*$taux_amortissement/100;
            $annuite4=$cout_acquisition*$taux_amortissement/100;
            $annuite5=$cout_acquisition*$taux_amortissement/100;
            $annuite6=$cout_acquisition*$taux_amortissement/100;
            $annuite7=$cout_acquisition*$taux_amortissement/100;
            $annuite8=$cout_acquisition*$taux_amortissement/100;
            $annuite9=$cout_acquisition*$taux_amortissement/100;

            $annuite10=$cout_acquisition*$taux_amortissement/100;
            $annuite11=$cout_acquisition*$taux_amortissement/100;
            $annuite12=$cout_acquisition*$taux_amortissement/100;
            $annuite13=$cout_acquisition*$taux_amortissement/100;
            $annuite14=$cout_acquisition*$taux_amortissement/100;
            $annuite15=$cout_acquisition*$taux_amortissement/100;
            $annuite16=$cout_acquisition*$taux_amortissement/100;
            $annuite17=$cout_acquisition*$taux_amortissement/100;
            $annuite18=$cout_acquisition*$taux_amortissement/100;
            $annuite19=$cout_acquisition*$taux_amortissement/100;
            $annuite20=$cout_acquisition*$taux_amortissement/100;
            $annuite21=$cout_acquisition*$taux_amortissement*$a2/1200;
             
            $annuite_cumule_1=$annuite;
            $annuite_cumule_2=$annuite_cumule_1+$annuite2;
            $annuite_cumule_3=$annuite_cumule_2+$annuite3;
            $annuite_cumule_4=$annuite_cumule_3+$annuite4;
            $annuite_cumule_5=$annuite_cumule_4+$annuite5;
            $annuite_cumule_6=$annuite_cumule_5+$annuite6;
            $annuite_cumule_7=$annuite_cumule_6+$annuite7;
            $annuite_cumule_8=$annuite_cumule_7+$annuite8;

            $annuite_cumule_9=$annuite_cumule_8+$annuite9;
            $annuite_cumule_10=$annuite_cumule_9+$annuite10;
            $annuite_cumule_11=$annuite_cumule_10+$annuite11;
            $annuite_cumule_12=$annuite_cumule_11+$annuite12;
            $annuite_cumule_13=$annuite_cumule_12+$annuite13;
            $annuite_cumule_14=$annuite_cumule_13+$annuite14;
            $annuite_cumule_15=$annuite_cumule_14+$annuite15;
            
            $annuite_cumule_16=$annuite_cumule_15+$annuite16;
            $annuite_cumule_17=$annuite_cumule_16+$annuite17;
            $annuite_cumule_18=$annuite_cumule_17+$annuite18;
            $annuite_cumule_19=$annuite_cumule_18+$annuite19;
            $annuite_cumule_20=$annuite_cumule_19+$annuite20;
            $annuite_cumule_21=$annuite_cumule_20+$annuite21;



            $vnc1=$cout_acquisition-$annuite_cumule_1;
            $vnc2=$cout_acquisition-$annuite_cumule_2;
            $vnc3=$cout_acquisition-$annuite_cumule_3;
            $vnc4=$cout_acquisition-$annuite_cumule_4;
            $vnc5=$cout_acquisition-$annuite_cumule_5;
            $vnc6=$cout_acquisition - $annuite_cumule_6;
            $vnc7=$cout_acquisition-$annuite_cumule_7;
            $vnc8=$cout_acquisition-$annuite_cumule_8;
            $vnc9=$cout_acquisition-$annuite_cumule_9;
            $vnc10=$cout_acquisition-$annuite_cumule_10;
            $vnc11=$cout_acquisition-$annuite_cumule_11;
            $vnc12=$cout_acquisition - $annuite_cumule_12;
            

            $vnc13=$cout_acquisition-$annuite_cumule_13;
            $vnc14=$cout_acquisition-$annuite_cumule_14;
            $vnc15=$cout_acquisition-$annuite_cumule_15;
            $vnc16=$cout_acquisition-$annuite_cumule_16;
            $vnc17=$cout_acquisition-$annuite_cumule_17;
            $vnc18=$cout_acquisition - $annuite_cumule_18;
            $vnc19=$cout_acquisition-$annuite_cumule_19;
            $vnc20=$cout_acquisition-$annuite_cumule_20;
            $vnc21=$cout_acquisition-$annuite_cumule_21;
            
    
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row ">
                        
                         <div class="col-2  mt-2 pt-1 "style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux</h6>
                         </div>
                     </div>
                     <div class="row ">
                         
                     <div class="col-2   pt-1 "style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             15ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc15?> </h6>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             16ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc16?> </h6>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             17ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc17?> </h6>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             18ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc18?> </h6>
                         </div>
                     </div>
                                                                
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             19ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite19?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_19?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc19?> </h6>
                         </div>
                     </div>
                                                            
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             20ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite20?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_20?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc20?> </h6>
                         </div>
                     </div>
                                                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             21ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite21?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_21?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc21?> </h6>
                         </div>
                     </div><hr>
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
    <!-- pour le syteme degessif -->
 <?php
    if ($donnees['dureeS']==3 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  


             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

         
   
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div><hr>
                    
                
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>

        <?php
    if ($donnees['dureeS']==4 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 



             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
    
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div><hr>
            
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
     <?php
    if ($donnees['dureeS']==5 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 


             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

  
   
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                      
                
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
      <?php
    if ($donnees['dureeS']==6 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 

             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

   
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> <hr>

                   
                
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
     <?php
    if ($donnees['dureeS']==7 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 
  $moist8= $moist7-12;
  $t8=12/$moist8 *100 ; 
 
             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

                         
       $vo8=$vnc7;
       if ($taux_degressif>$t8) {
          $annuite8=$vo8 * $taux_degressif/100;
          
      }else {
          $annuite8=$vo8 *$t8/100;
      }
      $annuite_cumule_8=$annuite_cumule_7+$annuite8;
      $vnc8=$vo8-$annuite8;

     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo8?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist8= $moist7-12;
                               echo $t8=12/$moist8 *100 .'%';
                          ?>
                         </div>
                     </div>
                        
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
       
     <?php
    if ($donnees['dureeS']==8 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 
  $moist8= $moist7-12;
  $t8=12/$moist8 *100 ; 
  $moist9= $moist8-12;
  $t9=12/$moist9 *100 ; 



             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

                         
       $vo8=$vnc7;
       if ($taux_degressif>$t8) {
          $annuite8=$vo8 * $taux_degressif/100;
          
      }else {
          $annuite8=$vo8 *$t8/100;
      }
      $annuite_cumule_8=$annuite_cumule_7+$annuite8;
      $vnc8=$vo8-$annuite8;

                         
      $vo9=$vnc8;
      if ($taux_degressif>$t9) {
         $annuite9=$vo9 * $taux_degressif/100;
         
     }else {
         $annuite9=$vo9 *$t9/100;
     }
     $annuite_cumule_9=$annuite_cumule_8+$annuite9;
     $vnc9=$vo9-$annuite9;


   
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo8?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist8= $moist7-12;
                               echo $t8=12/$moist8 *100 .'%';
                          ?>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo9?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist9= $moist8-12;
                               echo $t9=12/$moist9 *100 .'%';
                          ?>
                         </div>
                     </div><hr>
                  
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
      <?php
    if ($donnees['dureeS']==9 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 
  $moist8= $moist7-12;
  $t8=12/$moist8 *100 ; 
  $moist9= $moist8-12;
  $t9=12/$moist9 *100 ; 
  $moist10= $moist9-12;
  $t10=12/$moist10 *100 ; 

             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

                         
       $vo8=$vnc7;
       if ($taux_degressif>$t8) {
          $annuite8=$vo8 * $taux_degressif/100;
          
      }else {
          $annuite8=$vo8 *$t8/100;
      }
      $annuite_cumule_8=$annuite_cumule_7+$annuite8;
      $vnc8=$vo8-$annuite8;

                         
      $vo9=$vnc8;
      if ($taux_degressif>$t9) {
         $annuite9=$vo9 * $taux_degressif/100;
         
     }else {
         $annuite9=$vo9 *$t9/100;
     }
     $annuite_cumule_9=$annuite_cumule_8+$annuite9;
     $vnc9=$vo9-$annuite9;
                         
     $vo10=$vnc9;
     if ($taux_degressif>$t10) {
        $annuite10=$vo10 * $taux_degressif/100;
        
    }else {
        $annuite10=$vo10 *$t10/100;
    }
    $annuite_cumule_10=$annuite_cumule_9+$annuite10;
    $vnc10=$vo10-$annuite10;

     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo8?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist8= $moist7-12;
                               echo $t8=12/$moist8 *100 .'%';
                          ?>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo9?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist9= $moist8-12;
                               echo $t9=12/$moist9 *100 .'%';
                          ?>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo10?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist10= $moist9-12;
                               echo $t10=12/$moist10 *100 .'%';
                          ?>
                         </div>
                     </div>

                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
     <?php
    if ($donnees['dureeS']==10 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 
  $moist8= $moist7-12;
  $t8=12/$moist8 *100 ; 
  $moist9= $moist8-12;
  $t9=12/$moist9 *100 ; 
  $moist10= $moist9-12;
  $t10=12/$moist10 *100 ; 
  $moist11= $moist10-12;
  $t11=12/$moist11 *100 ; 

             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

                         
       $vo8=$vnc7;
       if ($taux_degressif>$t8) {
          $annuite8=$vo8 * $taux_degressif/100;
          
      }else {
          $annuite8=$vo8 *$t8/100;
      }
      $annuite_cumule_8=$annuite_cumule_7+$annuite8;
      $vnc8=$vo8-$annuite8;

                         
      $vo9=$vnc8;
      if ($taux_degressif>$t9) {
         $annuite9=$vo9 * $taux_degressif/100;
         
     }else {
         $annuite9=$vo9 *$t9/100;
     }
     $annuite_cumule_9=$annuite_cumule_8+$annuite9;
     $vnc9=$vo9-$annuite9;
                         
     $vo10=$vnc9;
     if ($taux_degressif>$t10) {
        $annuite10=$vo10 * $taux_degressif/100;
        
    }else {
        $annuite10=$vo10 *$t10/100;
    }
    $annuite_cumule_10=$annuite_cumule_9+$annuite10;
    $vnc10=$vo10-$annuite10;

                           
    $vo11=$vnc10;
    if ($taux_degressif>$t11) {
       $annuite11=$vo11 * $taux_degressif/100;
       
   }else {
       $annuite11=$vo11 *$t11/100;
   }
   $annuite_cumule_11=$annuite_cumule_10+$annuite11;
   $vnc11=$vo11-$annuite11;
   
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo8?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist8= $moist7-12;
                               echo $t8=12/$moist8 *100 .'%';
                          ?>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo9?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist9= $moist8-12;
                               echo $t9=12/$moist9 *100 .'%';
                          ?>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo10?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist10= $moist9-12;
                               echo $t10=12/$moist10 *100 .'%';
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo11?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist11= $moist10-12;
                               echo $t11=12/$moist11 *100 .'%';
                          ?>
                         </div>
                     </div>
                
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
         
<?php
    if ($donnees['dureeS']==11 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 
  $moist8= $moist7-12;
  $t8=12/$moist8 *100 ; 
  $moist9= $moist8-12;
  $t9=12/$moist9 *100 ; 
  $moist10= $moist9-12;
  $t10=12/$moist10 *100 ; 
  $moist11= $moist10-12;
  $t11=12/$moist11 *100 ; 
  $moist12= $moist11-12;
  $t12=12/$moist12 *100 ; 
  



             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

                         
       $vo8=$vnc7;
       if ($taux_degressif>$t8) {
          $annuite8=$vo8 * $taux_degressif/100;
          
      }else {
          $annuite8=$vo8 *$t8/100;
      }
      $annuite_cumule_8=$annuite_cumule_7+$annuite8;
      $vnc8=$vo8-$annuite8;

                         
      $vo9=$vnc8;
      if ($taux_degressif>$t9) {
         $annuite9=$vo9 * $taux_degressif/100;
         
     }else {
         $annuite9=$vo9 *$t9/100;
     }
     $annuite_cumule_9=$annuite_cumule_8+$annuite9;
     $vnc9=$vo9-$annuite9;
                         
     $vo10=$vnc9;
     if ($taux_degressif>$t10) {
        $annuite10=$vo10 * $taux_degressif/100;
        
    }else {
        $annuite10=$vo10 *$t10/100;
    }
    $annuite_cumule_10=$annuite_cumule_9+$annuite10;
    $vnc10=$vo10-$annuite10;

                           
    $vo11=$vnc10;
    if ($taux_degressif>$t11) {
       $annuite11=$vo11 * $taux_degressif/100;
       
   }else {
       $annuite11=$vo11 *$t11/100;
   }
   $annuite_cumule_11=$annuite_cumule_10+$annuite11;
   $vnc11=$vo11-$annuite11;
   
                           
   $vo12=$vnc11;
   if ($taux_degressif>$t12) {
      $annuite12=$vo12 * $taux_degressif/100;
      
  }else {
      $annuite12=$vo12 *$t12/100;
  }
  $annuite_cumule_12=$annuite_cumule_11+$annuite12;
  $vnc12=$vo12-$annuite12;


     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo8?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist8= $moist7-12;
                               echo $t8=12/$moist8 *100 .'%';
                          ?>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo9?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist9= $moist8-12;
                               echo $t9=12/$moist9 *100 .'%';
                          ?>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo10?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist10= $moist9-12;
                               echo $t10=12/$moist10 *100 .'%';
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo11?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist11= $moist10-12;
                               echo $t11=12/$moist11 *100 .'%';
                          ?>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo12?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist12= $moist11-12;
                               echo $t12=12/$moist12 *100 .'%';
                          ?>
                         </div>
                     </div><hr>
                                  
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
      
      <?php
    if ($donnees['dureeS']==12 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 
  $moist8= $moist7-12;
  $t8=12/$moist8 *100 ; 
  $moist9= $moist8-12;
  $t9=12/$moist9 *100 ; 
  $moist10= $moist9-12;
  $t10=12/$moist10 *100 ; 
  $moist11= $moist10-12;
  $t11=12/$moist11 *100 ; 
  $moist12= $moist11-12;
  $t12=12/$moist12 *100 ; 
  
  $moist13= $moist12-12;
  $t13=12/$moist13 *100 ; 

             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

                         
       $vo8=$vnc7;
       if ($taux_degressif>$t8) {
          $annuite8=$vo8 * $taux_degressif/100;
          
      }else {
          $annuite8=$vo8 *$t8/100;
      }
      $annuite_cumule_8=$annuite_cumule_7+$annuite8;
      $vnc8=$vo8-$annuite8;

                         
      $vo9=$vnc8;
      if ($taux_degressif>$t9) {
         $annuite9=$vo9 * $taux_degressif/100;
         
     }else {
         $annuite9=$vo9 *$t9/100;
     }
     $annuite_cumule_9=$annuite_cumule_8+$annuite9;
     $vnc9=$vo9-$annuite9;
                         
     $vo10=$vnc9;
     if ($taux_degressif>$t10) {
        $annuite10=$vo10 * $taux_degressif/100;
        
    }else {
        $annuite10=$vo10 *$t10/100;
    }
    $annuite_cumule_10=$annuite_cumule_9+$annuite10;
    $vnc10=$vo10-$annuite10;

                           
    $vo11=$vnc10;
    if ($taux_degressif>$t11) {
       $annuite11=$vo11 * $taux_degressif/100;
       
   }else {
       $annuite11=$vo11 *$t11/100;
   }
   $annuite_cumule_11=$annuite_cumule_10+$annuite11;
   $vnc11=$vo11-$annuite11;
   
                           
   $vo12=$vnc11;
   if ($taux_degressif>$t12) {
      $annuite12=$vo12 * $taux_degressif/100;
      
  }else {
      $annuite12=$vo12 *$t12/100;
  }
  $annuite_cumule_12=$annuite_cumule_11+$annuite12;
  $vnc12=$vo12-$annuite12;
                             
  $vo13=$vnc12;
  if ($taux_degressif>$t13) {
     $annuite13=$vo13 * $taux_degressif/100;
     
 }else {
     $annuite13=$vo13 *$t13/100;
 }
 $annuite_cumule_13=$annuite_cumule_12+$annuite13;
 $vnc13=$vo13-$annuite13;
     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo8?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist8= $moist7-12;
                               echo $t8=12/$moist8 *100 .'%';
                          ?>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo9?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist9= $moist8-12;
                               echo $t9=12/$moist9 *100 .'%';
                          ?>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo10?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist10= $moist9-12;
                               echo $t10=12/$moist10 *100 .'%';
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo11?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist11= $moist10-12;
                               echo $t11=12/$moist11 *100 .'%';
                          ?>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo12?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist12= $moist11-12;
                               echo $t12=12/$moist12 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo13?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist13= $moist12-12;
                               echo $t13=12/$moist13 *100 .'%';
                          ?>
                         </div>
                     </div><hr>
                  
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>   
     
    <?php
    if ($donnees['dureeS']==13 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 
  $moist8= $moist7-12;
  $t8=12/$moist8 *100 ; 
  $moist9= $moist8-12;
  $t9=12/$moist9 *100 ; 
  $moist10= $moist9-12;
  $t10=12/$moist10 *100 ; 
  $moist11= $moist10-12;
  $t11=12/$moist11 *100 ; 
  $moist12= $moist11-12;
  $t12=12/$moist12 *100 ; 
  
  $moist13= $moist12-12;
  $t13=12/$moist13 *100 ; 
  $moist14= $moist13-12;
  $t14=12/$moist14 *100 ; 

             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

                         
       $vo8=$vnc7;
       if ($taux_degressif>$t8) {
          $annuite8=$vo8 * $taux_degressif/100;
          
      }else {
          $annuite8=$vo8 *$t8/100;
      }
      $annuite_cumule_8=$annuite_cumule_7+$annuite8;
      $vnc8=$vo8-$annuite8;

                         
      $vo9=$vnc8;
      if ($taux_degressif>$t9) {
         $annuite9=$vo9 * $taux_degressif/100;
         
     }else {
         $annuite9=$vo9 *$t9/100;
     }
     $annuite_cumule_9=$annuite_cumule_8+$annuite9;
     $vnc9=$vo9-$annuite9;
                         
     $vo10=$vnc9;
     if ($taux_degressif>$t10) {
        $annuite10=$vo10 * $taux_degressif/100;
        
    }else {
        $annuite10=$vo10 *$t10/100;
    }
    $annuite_cumule_10=$annuite_cumule_9+$annuite10;
    $vnc10=$vo10-$annuite10;

                           
    $vo11=$vnc10;
    if ($taux_degressif>$t11) {
       $annuite11=$vo11 * $taux_degressif/100;
       
   }else {
       $annuite11=$vo11 *$t11/100;
   }
   $annuite_cumule_11=$annuite_cumule_10+$annuite11;
   $vnc11=$vo11-$annuite11;
   
                           
   $vo12=$vnc11;
   if ($taux_degressif>$t12) {
      $annuite12=$vo12 * $taux_degressif/100;
      
  }else {
      $annuite12=$vo12 *$t12/100;
  }
  $annuite_cumule_12=$annuite_cumule_11+$annuite12;
  $vnc12=$vo12-$annuite12;
                             
  $vo13=$vnc12;
  if ($taux_degressif>$t13) {
     $annuite13=$vo13 * $taux_degressif/100;
     
 }else {
     $annuite13=$vo13 *$t13/100;
 }
 $annuite_cumule_13=$annuite_cumule_12+$annuite13;
 $vnc13=$vo13-$annuite13;

                            
 $vo14=$vnc13;
 if ($taux_degressif>$t14) {
    $annuite14=$vo14 * $taux_degressif/100;
    
}else {
    $annuite14=$vo14 *$t14/100;
}
$annuite_cumule_14=$annuite_cumule_13+$annuite14;
$vnc14=$vo14-$annuite14;

     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo8?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist8= $moist7-12;
                               echo $t8=12/$moist8 *100 .'%';
                          ?>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo9?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist9= $moist8-12;
                               echo $t9=12/$moist9 *100 .'%';
                          ?>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo10?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist10= $moist9-12;
                               echo $t10=12/$moist10 *100 .'%';
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo11?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist11= $moist10-12;
                               echo $t11=12/$moist11 *100 .'%';
                          ?>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo12?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist12= $moist11-12;
                               echo $t12=12/$moist12 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo13?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist13= $moist12-12;
                               echo $t13=12/$moist13 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo14?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist14= $moist13-12;
                               echo $t14= 12/$moist14 *100 .'%';
                          ?>
                         </div>
                     </div><hr>
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>

    <?php
    if ($donnees['dureeS']==14 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 
  $moist8= $moist7-12;
  $t8=12/$moist8 *100 ; 
  $moist9= $moist8-12;
  $t9=12/$moist9 *100 ; 
  $moist10= $moist9-12;
  $t10=12/$moist10 *100 ; 
  $moist11= $moist10-12;
  $t11=12/$moist11 *100 ; 
  $moist12= $moist11-12;
  $t12=12/$moist12 *100 ; 
  
  $moist13= $moist12-12;
  $t13=12/$moist13 *100 ; 
  $moist14= $moist13-12;
  $t14=12/$moist14 *100 ; 
  $moist15= $moist14-12;
  $t15=12/$moist15 *100 ; 

             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

                         
       $vo8=$vnc7;
       if ($taux_degressif>$t8) {
          $annuite8=$vo8 * $taux_degressif/100;
          
      }else {
          $annuite8=$vo8 *$t8/100;
      }
      $annuite_cumule_8=$annuite_cumule_7+$annuite8;
      $vnc8=$vo8-$annuite8;

                         
      $vo9=$vnc8;
      if ($taux_degressif>$t9) {
         $annuite9=$vo9 * $taux_degressif/100;
         
     }else {
         $annuite9=$vo9 *$t9/100;
     }
     $annuite_cumule_9=$annuite_cumule_8+$annuite9;
     $vnc9=$vo9-$annuite9;
                         
     $vo10=$vnc9;
     if ($taux_degressif>$t10) {
        $annuite10=$vo10 * $taux_degressif/100;
        
    }else {
        $annuite10=$vo10 *$t10/100;
    }
    $annuite_cumule_10=$annuite_cumule_9+$annuite10;
    $vnc10=$vo10-$annuite10;

                           
    $vo11=$vnc10;
    if ($taux_degressif>$t11) {
       $annuite11=$vo11 * $taux_degressif/100;
       
   }else {
       $annuite11=$vo11 *$t11/100;
   }
   $annuite_cumule_11=$annuite_cumule_10+$annuite11;
   $vnc11=$vo11-$annuite11;
   
                           
   $vo12=$vnc11;
   if ($taux_degressif>$t12) {
      $annuite12=$vo12 * $taux_degressif/100;
      
  }else {
      $annuite12=$vo12 *$t12/100;
  }
  $annuite_cumule_12=$annuite_cumule_11+$annuite12;
  $vnc12=$vo12-$annuite12;
                             
  $vo13=$vnc12;
  if ($taux_degressif>$t13) {
     $annuite13=$vo13 * $taux_degressif/100;
     
 }else {
     $annuite13=$vo13 *$t13/100;
 }
 $annuite_cumule_13=$annuite_cumule_12+$annuite13;
 $vnc13=$vo13-$annuite13;

                            
 $vo14=$vnc13;
 if ($taux_degressif>$t14) {
    $annuite14=$vo14 * $taux_degressif/100;
    
}else {
    $annuite14=$vo14 *$t14/100;
}
$annuite_cumule_14=$annuite_cumule_13+$annuite14;
$vnc14=$vo14-$annuite14;
                          
$vo15=$vnc14;
if ($taux_degressif>$t15) {
   $annuite15=$vo15 * $taux_degressif/100;
   
}else {
   $annuite15=$vo15 *$t15/100;
}
$annuite_cumule_15=$annuite_cumule_14+$annuite15;
$vnc15=$vo15-$annuite15;


     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo8?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist8= $moist7-12;
                               echo $t8=12/$moist8 *100 .'%';
                          ?>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo9?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist9= $moist8-12;
                               echo $t9=12/$moist9 *100 .'%';
                          ?>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo10?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist10= $moist9-12;
                               echo $t10=12/$moist10 *100 .'%';
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo11?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist11= $moist10-12;
                               echo $t11=12/$moist11 *100 .'%';
                          ?>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo12?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist12= $moist11-12;
                               echo $t12=12/$moist12 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo13?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist13= $moist12-12;
                               echo $t13=12/$moist13 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo14?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist14= $moist13-12;
                               echo $t14= 12/$moist14 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             15ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo15?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc15?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist15= $moist14-12;
                               echo $t15=12/$moist15 *100 .'%';
                          ?>
                         </div>
                     </div><hr>

                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>

   <?php
    if ($donnees['dureeS']==15 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 
  $moist8= $moist7-12;
  $t8=12/$moist8 *100 ; 
  $moist9= $moist8-12;
  $t9=12/$moist9 *100 ; 
  $moist10= $moist9-12;
  $t10=12/$moist10 *100 ; 
  $moist11= $moist10-12;
  $t11=12/$moist11 *100 ; 
  $moist12= $moist11-12;
  $t12=12/$moist12 *100 ; 
  
  $moist13= $moist12-12;
  $t13=12/$moist13 *100 ; 
  $moist14= $moist13-12;
  $t14=12/$moist14 *100 ; 
  $moist15= $moist14-12;
  $t15=12/$moist15 *100 ; 
  $moist16= $moist15-12;
  $t16=12/$moist16 *100 ;  

             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

                         
       $vo8=$vnc7;
       if ($taux_degressif>$t8) {
          $annuite8=$vo8 * $taux_degressif/100;
          
      }else {
          $annuite8=$vo8 *$t8/100;
      }
      $annuite_cumule_8=$annuite_cumule_7+$annuite8;
      $vnc8=$vo8-$annuite8;

                         
      $vo9=$vnc8;
      if ($taux_degressif>$t9) {
         $annuite9=$vo9 * $taux_degressif/100;
         
     }else {
         $annuite9=$vo9 *$t9/100;
     }
     $annuite_cumule_9=$annuite_cumule_8+$annuite9;
     $vnc9=$vo9-$annuite9;
                         
     $vo10=$vnc9;
     if ($taux_degressif>$t10) {
        $annuite10=$vo10 * $taux_degressif/100;
        
    }else {
        $annuite10=$vo10 *$t10/100;
    }
    $annuite_cumule_10=$annuite_cumule_9+$annuite10;
    $vnc10=$vo10-$annuite10;

                           
    $vo11=$vnc10;
    if ($taux_degressif>$t11) {
       $annuite11=$vo11 * $taux_degressif/100;
       
   }else {
       $annuite11=$vo11 *$t11/100;
   }
   $annuite_cumule_11=$annuite_cumule_10+$annuite11;
   $vnc11=$vo11-$annuite11;
   
                           
   $vo12=$vnc11;
   if ($taux_degressif>$t12) {
      $annuite12=$vo12 * $taux_degressif/100;
      
  }else {
      $annuite12=$vo12 *$t12/100;
  }
  $annuite_cumule_12=$annuite_cumule_11+$annuite12;
  $vnc12=$vo12-$annuite12;
                             
  $vo13=$vnc12;
  if ($taux_degressif>$t13) {
     $annuite13=$vo13 * $taux_degressif/100;
     
 }else {
     $annuite13=$vo13 *$t13/100;
 }
 $annuite_cumule_13=$annuite_cumule_12+$annuite13;
 $vnc13=$vo13-$annuite13;

                            
 $vo14=$vnc13;
 if ($taux_degressif>$t14) {
    $annuite14=$vo14 * $taux_degressif/100;
    
}else {
    $annuite14=$vo14 *$t14/100;
}
$annuite_cumule_14=$annuite_cumule_13+$annuite14;
$vnc14=$vo14-$annuite14;
                          
$vo15=$vnc14;
if ($taux_degressif>$t15) {
   $annuite15=$vo15 * $taux_degressif/100;
   
}else {
   $annuite15=$vo15 *$t15/100;
}
$annuite_cumule_15=$annuite_cumule_14+$annuite15;
$vnc15=$vo15-$annuite15;
                          
$vo16=$vnc15;
if ($taux_degressif>$t16) {
   $annuite16=$vo16 * $taux_degressif/100;
   
}else {
   $annuite16=$vo16 *$t16/100;
}
$annuite_cumule_16=$annuite_cumule_15+$annuite16;
$vnc16=$vo16-$annuite16;

     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo8?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist8= $moist7-12;
                               echo $t8=12/$moist8 *100 .'%';
                          ?>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo9?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist9= $moist8-12;
                               echo $t9=12/$moist9 *100 .'%';
                          ?>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo10?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist10= $moist9-12;
                               echo $t10=12/$moist10 *100 .'%';
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo11?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist11= $moist10-12;
                               echo $t11=12/$moist11 *100 .'%';
                          ?>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo12?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist12= $moist11-12;
                               echo $t12=12/$moist12 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo13?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist13= $moist12-12;
                               echo $t13=12/$moist13 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo14?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist14= $moist13-12;
                               echo $t14= 12/$moist14 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             15ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo15?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc15?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist15= $moist14-12;
                               echo $t15=12/$moist15 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             16ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo16?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc16?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist16= $moist15-12;
                               echo $t16=12/$moist16 *100 .'%';
                          ?>
                         </div>
                     </div><hr>
                   
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>


   <?php
    if ($donnees['dureeS']==16 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 
  $moist8= $moist7-12;
  $t8=12/$moist8 *100 ; 
  $moist9= $moist8-12;
  $t9=12/$moist9 *100 ; 
  $moist10= $moist9-12;
  $t10=12/$moist10 *100 ; 
  $moist11= $moist10-12;
  $t11=12/$moist11 *100 ; 
  $moist12= $moist11-12;
  $t12=12/$moist12 *100 ; 
  
  $moist13= $moist12-12;
  $t13=12/$moist13 *100 ; 
  $moist14= $moist13-12;
  $t14=12/$moist14 *100 ; 
  $moist15= $moist14-12;
  $t15=12/$moist15 *100 ; 
  $moist16= $moist15-12;
  $t16=12/$moist16 *100 ; 
  $moist17= $moist16-12;
  $t17=12/$moist17 *100 ; 

             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

                         
       $vo8=$vnc7;
       if ($taux_degressif>$t8) {
          $annuite8=$vo8 * $taux_degressif/100;
          
      }else {
          $annuite8=$vo8 *$t8/100;
      }
      $annuite_cumule_8=$annuite_cumule_7+$annuite8;
      $vnc8=$vo8-$annuite8;

                         
      $vo9=$vnc8;
      if ($taux_degressif>$t9) {
         $annuite9=$vo9 * $taux_degressif/100;
         
     }else {
         $annuite9=$vo9 *$t9/100;
     }
     $annuite_cumule_9=$annuite_cumule_8+$annuite9;
     $vnc9=$vo9-$annuite9;
                         
     $vo10=$vnc9;
     if ($taux_degressif>$t10) {
        $annuite10=$vo10 * $taux_degressif/100;
        
    }else {
        $annuite10=$vo10 *$t10/100;
    }
    $annuite_cumule_10=$annuite_cumule_9+$annuite10;
    $vnc10=$vo10-$annuite10;

                           
    $vo11=$vnc10;
    if ($taux_degressif>$t11) {
       $annuite11=$vo11 * $taux_degressif/100;
       
   }else {
       $annuite11=$vo11 *$t11/100;
   }
   $annuite_cumule_11=$annuite_cumule_10+$annuite11;
   $vnc11=$vo11-$annuite11;
   
                           
   $vo12=$vnc11;
   if ($taux_degressif>$t12) {
      $annuite12=$vo12 * $taux_degressif/100;
      
  }else {
      $annuite12=$vo12 *$t12/100;
  }
  $annuite_cumule_12=$annuite_cumule_11+$annuite12;
  $vnc12=$vo12-$annuite12;
                             
  $vo13=$vnc12;
  if ($taux_degressif>$t13) {
     $annuite13=$vo13 * $taux_degressif/100;
     
 }else {
     $annuite13=$vo13 *$t13/100;
 }
 $annuite_cumule_13=$annuite_cumule_12+$annuite13;
 $vnc13=$vo13-$annuite13;

                            
 $vo14=$vnc13;
 if ($taux_degressif>$t14) {
    $annuite14=$vo14 * $taux_degressif/100;
    
}else {
    $annuite14=$vo14 *$t14/100;
}
$annuite_cumule_14=$annuite_cumule_13+$annuite14;
$vnc14=$vo14-$annuite14;
                          
$vo15=$vnc14;
if ($taux_degressif>$t15) {
   $annuite15=$vo15 * $taux_degressif/100;
   
}else {
   $annuite15=$vo15 *$t15/100;
}
$annuite_cumule_15=$annuite_cumule_14+$annuite15;
$vnc15=$vo15-$annuite15;
                          
$vo16=$vnc15;
if ($taux_degressif>$t16) {
   $annuite16=$vo16 * $taux_degressif/100;
   
}else {
   $annuite16=$vo16 *$t16/100;
}
$annuite_cumule_16=$annuite_cumule_15+$annuite16;
$vnc16=$vo16-$annuite16;

                          
$vo17=$vnc16;
if ($taux_degressif>$t17) {
   $annuite17=$vo17 * $taux_degressif/100;
   
}else {
   $annuite17=$vo17 *$t17/100;
}
$annuite_cumule_17=$annuite_cumule_16+$annuite17;
$vnc17=$vo17-$annuite17;


     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo8?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist8= $moist7-12;
                               echo $t8=12/$moist8 *100 .'%';
                          ?>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo9?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist9= $moist8-12;
                               echo $t9=12/$moist9 *100 .'%';
                          ?>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo10?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist10= $moist9-12;
                               echo $t10=12/$moist10 *100 .'%';
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo11?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist11= $moist10-12;
                               echo $t11=12/$moist11 *100 .'%';
                          ?>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo12?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist12= $moist11-12;
                               echo $t12=12/$moist12 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo13?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist13= $moist12-12;
                               echo $t13=12/$moist13 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo14?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist14= $moist13-12;
                               echo $t14= 12/$moist14 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             15ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo15?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc15?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist15= $moist14-12;
                               echo $t15=12/$moist15 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             16ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo16?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc16?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist16= $moist15-12;
                               echo $t16=12/$moist16 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             17ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo17?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc17?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist17= $moist16-12;
                               echo $t17=12/$moist17 *100 .'%';
                          ?>
                         </div>
                     </div><hr>
                          
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>

   
<?php
    if ($donnees['dureeS']==17 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 
  $moist8= $moist7-12;
  $t8=12/$moist8 *100 ; 
  $moist9= $moist8-12;
  $t9=12/$moist9 *100 ; 
  $moist10= $moist9-12;
  $t10=12/$moist10 *100 ; 
  $moist11= $moist10-12;
  $t11=12/$moist11 *100 ; 
  $moist12= $moist11-12;
  $t12=12/$moist12 *100 ; 
  
  $moist13= $moist12-12;
  $t13=12/$moist13 *100 ; 
  $moist14= $moist13-12;
  $t14=12/$moist14 *100 ; 
  $moist15= $moist14-12;
  $t15=12/$moist15 *100 ; 
  $moist16= $moist15-12;
  $t16=12/$moist16 *100 ; 
  $moist17= $moist16-12;
  $t17=12/$moist17 *100 ; 
  $moist18= $moist17-12;
  $t18=12/$moist18 *100 ; 
  $moist19= $moist18-12;

             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

                         
       $vo8=$vnc7;
       if ($taux_degressif>$t8) {
          $annuite8=$vo8 * $taux_degressif/100;
          
      }else {
          $annuite8=$vo8 *$t8/100;
      }
      $annuite_cumule_8=$annuite_cumule_7+$annuite8;
      $vnc8=$vo8-$annuite8;

                         
      $vo9=$vnc8;
      if ($taux_degressif>$t9) {
         $annuite9=$vo9 * $taux_degressif/100;
         
     }else {
         $annuite9=$vo9 *$t9/100;
     }
     $annuite_cumule_9=$annuite_cumule_8+$annuite9;
     $vnc9=$vo9-$annuite9;
                         
     $vo10=$vnc9;
     if ($taux_degressif>$t10) {
        $annuite10=$vo10 * $taux_degressif/100;
        
    }else {
        $annuite10=$vo10 *$t10/100;
    }
    $annuite_cumule_10=$annuite_cumule_9+$annuite10;
    $vnc10=$vo10-$annuite10;

                           
    $vo11=$vnc10;
    if ($taux_degressif>$t11) {
       $annuite11=$vo11 * $taux_degressif/100;
       
   }else {
       $annuite11=$vo11 *$t11/100;
   }
   $annuite_cumule_11=$annuite_cumule_10+$annuite11;
   $vnc11=$vo11-$annuite11;
   
                           
   $vo12=$vnc11;
   if ($taux_degressif>$t12) {
      $annuite12=$vo12 * $taux_degressif/100;
      
  }else {
      $annuite12=$vo12 *$t12/100;
  }
  $annuite_cumule_12=$annuite_cumule_11+$annuite12;
  $vnc12=$vo12-$annuite12;
                             
  $vo13=$vnc12;
  if ($taux_degressif>$t13) {
     $annuite13=$vo13 * $taux_degressif/100;
     
 }else {
     $annuite13=$vo13 *$t13/100;
 }
 $annuite_cumule_13=$annuite_cumule_12+$annuite13;
 $vnc13=$vo13-$annuite13;

                            
 $vo14=$vnc13;
 if ($taux_degressif>$t14) {
    $annuite14=$vo14 * $taux_degressif/100;
    
}else {
    $annuite14=$vo14 *$t14/100;
}
$annuite_cumule_14=$annuite_cumule_13+$annuite14;
$vnc14=$vo14-$annuite14;
                          
$vo15=$vnc14;
if ($taux_degressif>$t15) {
   $annuite15=$vo15 * $taux_degressif/100;
   
}else {
   $annuite15=$vo15 *$t15/100;
}
$annuite_cumule_15=$annuite_cumule_14+$annuite15;
$vnc15=$vo15-$annuite15;
                          
$vo16=$vnc15;
if ($taux_degressif>$t16) {
   $annuite16=$vo16 * $taux_degressif/100;
   
}else {
   $annuite16=$vo16 *$t16/100;
}
$annuite_cumule_16=$annuite_cumule_15+$annuite16;
$vnc16=$vo16-$annuite16;

                          
$vo17=$vnc16;
if ($taux_degressif>$t17) {
   $annuite17=$vo17 * $taux_degressif/100;
   
}else {
   $annuite17=$vo17 *$t17/100;
}
$annuite_cumule_17=$annuite_cumule_16+$annuite17;
$vnc17=$vo17-$annuite17;
                          
$vo18=$vnc17;
if ($taux_degressif>$t18) {
   $annuite18=$vo18 * $taux_degressif/100;
   
}else {
   $annuite18=$vo18 *$t18/100;
}
$annuite_cumule_18=$annuite_cumule_17+$annuite18;
$vnc18=$vo18-$annuite18;
 

     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo8?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist8= $moist7-12;
                               echo $t8=12/$moist8 *100 .'%';
                          ?>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo9?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist9= $moist8-12;
                               echo $t9=12/$moist9 *100 .'%';
                          ?>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo10?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist10= $moist9-12;
                               echo $t10=12/$moist10 *100 .'%';
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo11?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist11= $moist10-12;
                               echo $t11=12/$moist11 *100 .'%';
                          ?>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo12?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist12= $moist11-12;
                               echo $t12=12/$moist12 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo13?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist13= $moist12-12;
                               echo $t13=12/$moist13 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo14?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist14= $moist13-12;
                               echo $t14= 12/$moist14 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             15ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo15?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc15?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist15= $moist14-12;
                               echo $t15=12/$moist15 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             16ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo16?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc16?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist16= $moist15-12;
                               echo $t16=12/$moist16 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             17ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo17?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc17?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist17= $moist16-12;
                               echo $t17=12/$moist17 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             18ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo18?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc18?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist18= $moist17-12;
                               echo $t18=12/$moist18 *100 .'%';
                          ?>
                         </div>
                     </div><hr>
                          
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
    
<?php
    if ($donnees['dureeS']==18 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 
  $moist8= $moist7-12;
  $t8=12/$moist8 *100 ; 
  $moist9= $moist8-12;
  $t9=12/$moist9 *100 ; 
  $moist10= $moist9-12;
  $t10=12/$moist10 *100 ; 
  $moist11= $moist10-12;
  $t11=12/$moist11 *100 ; 
  $moist12= $moist11-12;
  $t12=12/$moist12 *100 ; 
  
  $moist13= $moist12-12;
  $t13=12/$moist13 *100 ; 
  $moist14= $moist13-12;
  $t14=12/$moist14 *100 ; 
  $moist15= $moist14-12;
  $t15=12/$moist15 *100 ; 
  $moist16= $moist15-12;
  $t16=12/$moist16 *100 ; 
  $moist17= $moist16-12;
  $t17=12/$moist17 *100 ; 
  $moist18= $moist17-12;
  $t18=12/$moist18 *100 ; 
  $moist19= $moist18-12;
  $t19=12/$moist19 *100 ;


             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

                         
       $vo8=$vnc7;
       if ($taux_degressif>$t8) {
          $annuite8=$vo8 * $taux_degressif/100;
          
      }else {
          $annuite8=$vo8 *$t8/100;
      }
      $annuite_cumule_8=$annuite_cumule_7+$annuite8;
      $vnc8=$vo8-$annuite8;

                         
      $vo9=$vnc8;
      if ($taux_degressif>$t9) {
         $annuite9=$vo9 * $taux_degressif/100;
         
     }else {
         $annuite9=$vo9 *$t9/100;
     }
     $annuite_cumule_9=$annuite_cumule_8+$annuite9;
     $vnc9=$vo9-$annuite9;
                         
     $vo10=$vnc9;
     if ($taux_degressif>$t10) {
        $annuite10=$vo10 * $taux_degressif/100;
        
    }else {
        $annuite10=$vo10 *$t10/100;
    }
    $annuite_cumule_10=$annuite_cumule_9+$annuite10;
    $vnc10=$vo10-$annuite10;

                           
    $vo11=$vnc10;
    if ($taux_degressif>$t11) {
       $annuite11=$vo11 * $taux_degressif/100;
       
   }else {
       $annuite11=$vo11 *$t11/100;
   }
   $annuite_cumule_11=$annuite_cumule_10+$annuite11;
   $vnc11=$vo11-$annuite11;
   
                           
   $vo12=$vnc11;
   if ($taux_degressif>$t12) {
      $annuite12=$vo12 * $taux_degressif/100;
      
  }else {
      $annuite12=$vo12 *$t12/100;
  }
  $annuite_cumule_12=$annuite_cumule_11+$annuite12;
  $vnc12=$vo12-$annuite12;
                             
  $vo13=$vnc12;
  if ($taux_degressif>$t13) {
     $annuite13=$vo13 * $taux_degressif/100;
     
 }else {
     $annuite13=$vo13 *$t13/100;
 }
 $annuite_cumule_13=$annuite_cumule_12+$annuite13;
 $vnc13=$vo13-$annuite13;

                            
 $vo14=$vnc13;
 if ($taux_degressif>$t14) {
    $annuite14=$vo14 * $taux_degressif/100;
    
}else {
    $annuite14=$vo14 *$t14/100;
}
$annuite_cumule_14=$annuite_cumule_13+$annuite14;
$vnc14=$vo14-$annuite14;
                          
$vo15=$vnc14;
if ($taux_degressif>$t15) {
   $annuite15=$vo15 * $taux_degressif/100;
   
}else {
   $annuite15=$vo15 *$t15/100;
}
$annuite_cumule_15=$annuite_cumule_14+$annuite15;
$vnc15=$vo15-$annuite15;
                          
$vo16=$vnc15;
if ($taux_degressif>$t16) {
   $annuite16=$vo16 * $taux_degressif/100;
   
}else {
   $annuite16=$vo16 *$t16/100;
}
$annuite_cumule_16=$annuite_cumule_15+$annuite16;
$vnc16=$vo16-$annuite16;

                          
$vo17=$vnc16;
if ($taux_degressif>$t17) {
   $annuite17=$vo17 * $taux_degressif/100;
   
}else {
   $annuite17=$vo17 *$t17/100;
}
$annuite_cumule_17=$annuite_cumule_16+$annuite17;
$vnc17=$vo17-$annuite17;
                          
$vo18=$vnc17;
if ($taux_degressif>$t18) {
   $annuite18=$vo18 * $taux_degressif/100;
   
}else {
   $annuite18=$vo18 *$t18/100;
}
$annuite_cumule_18=$annuite_cumule_17+$annuite18;
$vnc18=$vo18-$annuite18;
                          
$vo19=$vnc18;
if ($taux_degressif>$t19) {
   $annuite19=$vo19 * $taux_degressif/100;
   
}else {
   $annuite19=$vo19 *$t19/100;
}
$annuite_cumule_19=$annuite_cumule_18+$annuite19;
$vnc19=$vo19-$annuite19;


  
  
  
 
   
   
    
     
      
    

     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo8?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist8= $moist7-12;
                               echo $t8=12/$moist8 *100 .'%';
                          ?>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo9?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist9= $moist8-12;
                               echo $t9=12/$moist9 *100 .'%';
                          ?>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo10?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist10= $moist9-12;
                               echo $t10=12/$moist10 *100 .'%';
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo11?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist11= $moist10-12;
                               echo $t11=12/$moist11 *100 .'%';
                          ?>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo12?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist12= $moist11-12;
                               echo $t12=12/$moist12 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo13?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist13= $moist12-12;
                               echo $t13=12/$moist13 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo14?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist14= $moist13-12;
                               echo $t14= 12/$moist14 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             15ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo15?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc15?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist15= $moist14-12;
                               echo $t15=12/$moist15 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             16ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo16?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc16?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist16= $moist15-12;
                               echo $t16=12/$moist16 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             17ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo17?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc17?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist17= $moist16-12;
                               echo $t17=12/$moist17 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             18ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo18?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc18?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist18= $moist17-12;
                               echo $t18=12/$moist18 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                                
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             19ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo19?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite19?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_19?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc19?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist19= $moist18-12;
                               echo $t19=12/$moist19 *100 .'%';
                          ?>
                         </div>
                     </div><hr>
                                                            
                    
                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
    
<?php
    if ($donnees['dureeS']==19 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 
  $moist8= $moist7-12;
  $t8=12/$moist8 *100 ; 
  $moist9= $moist8-12;
  $t9=12/$moist9 *100 ; 
  $moist10= $moist9-12;
  $t10=12/$moist10 *100 ; 
  $moist11= $moist10-12;
  $t11=12/$moist11 *100 ; 
  $moist12= $moist11-12;
  $t12=12/$moist12 *100 ; 
  
  $moist13= $moist12-12;
  $t13=12/$moist13 *100 ; 
  $moist14= $moist13-12;
  $t14=12/$moist14 *100 ; 
  $moist15= $moist14-12;
  $t15=12/$moist15 *100 ; 
  $moist16= $moist15-12;
  $t16=12/$moist16 *100 ; 
  $moist17= $moist16-12;
  $t17=12/$moist17 *100 ; 
  $moist18= $moist17-12;
  $t18=12/$moist18 *100 ; 
  $moist19= $moist18-12;
  $t19=12/$moist19 *100 ;
  
  $moist20= $moist19-12;
  $t20=12/$moist20 *100 ; 
  $moist21= $moist20-12;

 

    

             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

                         
       $vo8=$vnc7;
       if ($taux_degressif>$t8) {
          $annuite8=$vo8 * $taux_degressif/100;
          
      }else {
          $annuite8=$vo8 *$t8/100;
      }
      $annuite_cumule_8=$annuite_cumule_7+$annuite8;
      $vnc8=$vo8-$annuite8;

                         
      $vo9=$vnc8;
      if ($taux_degressif>$t9) {
         $annuite9=$vo9 * $taux_degressif/100;
         
     }else {
         $annuite9=$vo9 *$t9/100;
     }
     $annuite_cumule_9=$annuite_cumule_8+$annuite9;
     $vnc9=$vo9-$annuite9;
                         
     $vo10=$vnc9;
     if ($taux_degressif>$t10) {
        $annuite10=$vo10 * $taux_degressif/100;
        
    }else {
        $annuite10=$vo10 *$t10/100;
    }
    $annuite_cumule_10=$annuite_cumule_9+$annuite10;
    $vnc10=$vo10-$annuite10;

                           
    $vo11=$vnc10;
    if ($taux_degressif>$t11) {
       $annuite11=$vo11 * $taux_degressif/100;
       
   }else {
       $annuite11=$vo11 *$t11/100;
   }
   $annuite_cumule_11=$annuite_cumule_10+$annuite11;
   $vnc11=$vo11-$annuite11;
   
                           
   $vo12=$vnc11;
   if ($taux_degressif>$t12) {
      $annuite12=$vo12 * $taux_degressif/100;
      
  }else {
      $annuite12=$vo12 *$t12/100;
  }
  $annuite_cumule_12=$annuite_cumule_11+$annuite12;
  $vnc12=$vo12-$annuite12;
                             
  $vo13=$vnc12;
  if ($taux_degressif>$t13) {
     $annuite13=$vo13 * $taux_degressif/100;
     
 }else {
     $annuite13=$vo13 *$t13/100;
 }
 $annuite_cumule_13=$annuite_cumule_12+$annuite13;
 $vnc13=$vo13-$annuite13;

                            
 $vo14=$vnc13;
 if ($taux_degressif>$t14) {
    $annuite14=$vo14 * $taux_degressif/100;
    
}else {
    $annuite14=$vo14 *$t14/100;
}
$annuite_cumule_14=$annuite_cumule_13+$annuite14;
$vnc14=$vo14-$annuite14;
                          
$vo15=$vnc14;
if ($taux_degressif>$t15) {
   $annuite15=$vo15 * $taux_degressif/100;
   
}else {
   $annuite15=$vo15 *$t15/100;
}
$annuite_cumule_15=$annuite_cumule_14+$annuite15;
$vnc15=$vo15-$annuite15;
                          
$vo16=$vnc15;
if ($taux_degressif>$t16) {
   $annuite16=$vo16 * $taux_degressif/100;
   
}else {
   $annuite16=$vo16 *$t16/100;
}
$annuite_cumule_16=$annuite_cumule_15+$annuite16;
$vnc16=$vo16-$annuite16;

                          
$vo17=$vnc16;
if ($taux_degressif>$t17) {
   $annuite17=$vo17 * $taux_degressif/100;
   
}else {
   $annuite17=$vo17 *$t17/100;
}
$annuite_cumule_17=$annuite_cumule_16+$annuite17;
$vnc17=$vo17-$annuite17;
                          
$vo18=$vnc17;
if ($taux_degressif>$t18) {
   $annuite18=$vo18 * $taux_degressif/100;
   
}else {
   $annuite18=$vo18 *$t18/100;
}
$annuite_cumule_18=$annuite_cumule_17+$annuite18;
$vnc18=$vo18-$annuite18;
                          
$vo19=$vnc18;
if ($taux_degressif>$t19) {
   $annuite19=$vo19 * $taux_degressif/100;
   
}else {
   $annuite19=$vo19 *$t19/100;
}
$annuite_cumule_19=$annuite_cumule_18+$annuite19;
$vnc19=$vo19-$annuite19;
                          
$vo20=$vnc19;
if ($taux_degressif>$t20) {
   $annuite20=$vo20 * $taux_degressif/100;
   
}else {
   $annuite20=$vo20 *$t20/100;
}
$annuite_cumule_20=$annuite_cumule_19+$annuite20;
$vnc20=$vo20-$annuite20;

  
  
  
 
   
   
    
     
      
    

     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=  $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo8?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist8= $moist7-12;
                               echo $t8=12/$moist8 *100 .'%';
                          ?>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo9?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist9= $moist8-12;
                               echo $t9=12/$moist9 *100 .'%';
                          ?>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo10?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist10= $moist9-12;
                               echo $t10=12/$moist10 *100 .'%';
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo11?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist11= $moist10-12;
                               echo $t11=12/$moist11 *100 .'%';
                          ?>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo12?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist12= $moist11-12;
                               echo $t12=12/$moist12 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo13?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist13= $moist12-12;
                               echo $t13=12/$moist13 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo14?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist14= $moist13-12;
                               echo $t14= 12/$moist14 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             15ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo15?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc15?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist15= $moist14-12;
                               echo $t15=12/$moist15 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             16ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo16?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc16?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist16= $moist15-12;
                               echo $t16=12/$moist16 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             17ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo17?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc17?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist17= $moist16-12;
                               echo $t17=12/$moist17 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             18ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo18?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc18?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist18= $moist17-12;
                               echo $t18=12/$moist18 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                                
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             19ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo19?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite19?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_19?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc19?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist19= $moist18-12;
                               echo $t19=12/$moist19 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                            
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             20ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo20?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite20?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_20?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc20?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist20= $moist19-12;
                               echo $t20=12/$moist20 *100 .'%';
                          ?>
                         </div>
                     </div>

                 </div>
             </div>
         </div>
     </div>
     <?php
      }
    ?>
    
<?php
    if ($donnees['dureeS']==20 AND $donnees['systemeS']=='Dégréssif') {
            if ($donnees['moisS']>0) 
            {
                $a1=12-$donnees['moisS'];
                $a2=12-$a1;
            }


            if ($donnees['dureeS']== 5 OR $donnees['dureeS']== 6)
                           {
                           $taux_degressif= $taux_amortissement *2 ;

                          }elseif ($donnees['dureeS']== 3 OR $donnees['dureeS'] ==4 )
                          {
                          $taux_degressif= $taux_amortissement * 1.5 ;
                          }
                          else {
                             $taux_degressif= $taux_amortissement*3 ;
                          }

        
           
  $totalmois=$donnees['dureeS']*12;
  $taux_linaire = $donnees['moisS']/$totalmois *100;          
  $moist2=$totalmois-$donnees['moisS'];
  $t2= 12/$moist2 *100 ;

  $moist3=$totalmois-12;
  $t3= 12/$moist3 *100 ;

  $moist4= $moist3-12;
  $t4=12/$moist4 *100 ;  
  
  $moist5= $moist4-12;
  $t5=12/$moist5 *100 ; 
  $moist6= $moist5-12;
  $t6=12/$moist6 *100 ; 
  $moist7= $moist6-12;
  $t7=12/$moist7 *100 ; 
  $moist8= $moist7-12;
  $t8=12/$moist8 *100 ; 
  $moist9= $moist8-12;
  $t9=12/$moist9 *100 ; 
  $moist10= $moist9-12;
  $t10=12/$moist10 *100 ; 
  $moist11= $moist10-12;
  $t11=12/$moist11 *100 ; 
  $moist12= $moist11-12;
  $t12=12/$moist12 *100 ; 
  
  $moist13= $moist12-12;
  $t13=12/$moist13 *100 ; 
  $moist14= $moist13-12;
  $t14=12/$moist14 *100 ; 
  $moist15= $moist14-12;
  $t15=12/$moist15 *100 ; 
  $moist16= $moist15-12;
  $t16=12/$moist16 *100 ; 
  $moist17= $moist16-12;
  $t17=12/$moist17 *100 ; 
  $moist18= $moist17-12;
  $t18=12/$moist18 *100 ; 
  $moist19= $moist18-12;
  $t19=12/$moist19 *100 ;
  
  $moist20= $moist19-12;
  $t20=12/$moist20 *100 ; 
  $moist21= $moist20-12;
  $t21=12/$moist21 *100 ; 
 

    

             if ($taux_degressif>$taux_linaire ) {
                 $annuite1= $cout_acquisition* $taux_degressif*$a1/1200;
                 
             }else {
                $annuite=$cout_acquisition*$taux_linaire *$a1/1200;
             }
             $annuite_cumule_1=$annuite1;
             $vnc1=$cout_acquisition-$annuite_cumule_1;

             $vo2=$vnc1;
             if ($taux_degressif>$t2) {
                $annuite2=$vo2 * $taux_degressif/100;
                
            }else {
                $annuite2=$vo2 *$t2/100;
            }
            $annuite_cumule_2=$annuite1+$annuite2;
            $vnc2=$vo2-$annuite2;
            
            $vo3=$vnc2;
            if ($taux_degressif>$t3) {
               $annuite3=$vo3 * $taux_degressif/100;
               
           }else {
               $annuite3=$vo3 *$t3/100;
           }
           $annuite_cumule_3=$annuite_cumule_2+$annuite3;
           $vnc3=$vo3-$annuite3;

                       
           $vo4=$vnc3;
           if ($taux_degressif>$t4) {
              $annuite4=$vo4 * $taux_degressif/100;
              
          }else {
              $annuite4=$vo4 *$t4/100;
          }
          $annuite_cumule_4=$annuite_cumule_3+$annuite4;
          $vnc4=$vo4-$annuite4;

                        
          $vo5=$vnc4;
          if ($taux_degressif>$t5) {
             $annuite5=$vo5 * $taux_degressif/100;
             
         }else {
             $annuite5=$vo5 *$t5/100;
         }
         $annuite_cumule_5=$annuite_cumule_4+$annuite5;
         $vnc5=$vo5-$annuite5;
                       
         $vo6=$vnc5;
         if ($taux_degressif>$t6) {
            $annuite6=$vo6 * $taux_degressif/100;
            
        }else {
            $annuite6=$vo6 *$t6/100;
        }
        $annuite_cumule_6=$annuite_cumule_5+$annuite6;
        $vnc6=$vo6-$annuite6;

                        
        $vo7=$vnc6;
        if ($taux_degressif>$t7) {
           $annuite7=$vo7 * $taux_degressif/100;
           
       }else {
           $annuite7=$vo7 *$t7/100;
       }
       $annuite_cumule_7=$annuite_cumule_6+$annuite7;
       $vnc7=$vo7-$annuite7;

                         
       $vo8=$vnc7;
       if ($taux_degressif>$t8) {
          $annuite8=$vo8 * $taux_degressif/100;
          
      }else {
          $annuite8=$vo8 *$t8/100;
      }
      $annuite_cumule_8=$annuite_cumule_7+$annuite8;
      $vnc8=$vo8-$annuite8;

                         
      $vo9=$vnc8;
      if ($taux_degressif>$t9) {
         $annuite9=$vo9 * $taux_degressif/100;
         
     }else {
         $annuite9=$vo9 *$t9/100;
     }
     $annuite_cumule_9=$annuite_cumule_8+$annuite9;
     $vnc9=$vo9-$annuite9;
                         
     $vo10=$vnc9;
     if ($taux_degressif>$t10) {
        $annuite10=$vo10 * $taux_degressif/100;
        
    }else {
        $annuite10=$vo10 *$t10/100;
    }
    $annuite_cumule_10=$annuite_cumule_9+$annuite10;
    $vnc10=$vo10-$annuite10;

                           
    $vo11=$vnc10;
    if ($taux_degressif>$t11) {
       $annuite11=$vo11 * $taux_degressif/100;
       
   }else {
       $annuite11=$vo11 *$t11/100;
   }
   $annuite_cumule_11=$annuite_cumule_10+$annuite11;
   $vnc11=$vo11-$annuite11;
   
                           
   $vo12=$vnc11;
   if ($taux_degressif>$t12) {
      $annuite12=$vo12 * $taux_degressif/100;
      
  }else {
      $annuite12=$vo12 *$t12/100;
  }
  $annuite_cumule_12=$annuite_cumule_11+$annuite12;
  $vnc12=$vo12-$annuite12;
                             
  $vo13=$vnc12;
  if ($taux_degressif>$t13) {
     $annuite13=$vo13 * $taux_degressif/100;
     
 }else {
     $annuite13=$vo13 *$t13/100;
 }
 $annuite_cumule_13=$annuite_cumule_12+$annuite13;
 $vnc13=$vo13-$annuite13;

                            
 $vo14=$vnc13;
 if ($taux_degressif>$t14) {
    $annuite14=$vo14 * $taux_degressif/100;
    
}else {
    $annuite14=$vo14 *$t14/100;
}
$annuite_cumule_14=$annuite_cumule_13+$annuite14;
$vnc14=$vo14-$annuite14;
                          
$vo15=$vnc14;
if ($taux_degressif>$t15) {
   $annuite15=$vo15 * $taux_degressif/100;
   
}else {
   $annuite15=$vo15 *$t15/100;
}
$annuite_cumule_15=$annuite_cumule_14+$annuite15;
$vnc15=$vo15-$annuite15;
                          
$vo16=$vnc15;
if ($taux_degressif>$t16) {
   $annuite16=$vo16 * $taux_degressif/100;
   
}else {
   $annuite16=$vo16 *$t16/100;
}
$annuite_cumule_16=$annuite_cumule_15+$annuite16;
$vnc16=$vo16-$annuite16;

                          
$vo17=$vnc16;
if ($taux_degressif>$t17) {
   $annuite17=$vo17 * $taux_degressif/100;
   
}else {
   $annuite17=$vo17 *$t17/100;
}
$annuite_cumule_17=$annuite_cumule_16+$annuite17;
$vnc17=$vo17-$annuite17;
                          
$vo18=$vnc17;
if ($taux_degressif>$t18) {
   $annuite18=$vo18 * $taux_degressif/100;
   
}else {
   $annuite18=$vo18 *$t18/100;
}
$annuite_cumule_18=$annuite_cumule_17+$annuite18;
$vnc18=$vo18-$annuite18;
                          
$vo19=$vnc18;
if ($taux_degressif>$t19) {
   $annuite19=$vo19 * $taux_degressif/100;
   
}else {
   $annuite19=$vo19 *$t19/100;
}
$annuite_cumule_19=$annuite_cumule_18+$annuite19;
$vnc19=$vo19-$annuite19;
                          
$vo20=$vnc19;
if ($taux_degressif>$t20) {
   $annuite20=$vo20 * $taux_degressif/100;
   
}else {
   $annuite20=$vo20 *$t20/100;
}
$annuite_cumule_20=$annuite_cumule_19+$annuite20;
$vnc20=$vo20-$annuite20;
                          
$vo21=$vnc20;
if ($taux_degressif>$t21) {
   $annuite21=$vo21 * $taux_degressif/100;
   
}else {
   $annuite21=$vo21 *$t21/100;
}
$annuite_cumule_21=$annuite_cumule_20+$annuite21;
$vnc21=$vo21-$annuite21;
  
  
  
 
   
   
    
     
      
    

     ?>
     <div class="container">
         <div class="row">
             <div class="col-12">
                 

                     <hr><div class="row   ">
                        
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Mis en Service</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Coût</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Système</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Durée</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Linéaire</h6>
                         </div>
                         <div class="col-2  mt-2 pt-1"style='border:solid gray 0.5px'>
                             <h6>Taux Dégresif</h6>
                         </div>
                     </div>
                     <div class="row  ">
                         
                     <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                     <?php
                      if ($donnees['moisS']==1) {?>
                       <?=$donnees['moisS'] ?> èr moisS
                        <?php
                      } else {
                        ?>
                        <?=$donnees['moisS'] ?>  ème moisS
                        <?php
                      }
                      ?>

                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                             <?=$cout_acquisition?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['systemeS'] ?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$donnees['dureeS'] ?> ans
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_amortissement?> %
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$taux_degressif
                          
                         ?>
                    
                             
                              </div>
                      
                     
                     </div><hr>


                     <div class="row">
                     <div >
                             
                         </div>
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             <h6>Période</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Valeur d'origine</h6>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Annuité Cumule</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>   Valuer Net Comptable</h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6>Taux Lineaire</h6>
                         </div>
                     </div>
                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             1er Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$cout_acquisition?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         
                            <?=$annuite1?>
                         
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_1?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc1?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?= $taux_linaire 
                              
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             2ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo2?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_2?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc2?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                                $moist2=$totalmois-$donnees['moisS'];
                               echo $t2= 12/$moist2 *100 .'%';
                          ?>
                         </div>

                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             3ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo3?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_3?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc3?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?=$t3?>
                         </div>
                     </div>
                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             4ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo4?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_4?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc4?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist4= $moist3-12;
                               echo $t4=12/$moist4 *100 .'%';
                          ?>
                         </div>
                     </div>
                                   
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             5ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo5?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_5?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc5?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist5= $moist4-12;
                               echo $t5=12/$moist5 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             6ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo6?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_6?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc6?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist6= $moist5-12;
                               echo $t6=12/$moist6 *100 .'%';
                          ?>
                         </div>
                     </div>
                                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             7ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo7?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_7?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc7?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist7= $moist6-12;
                               echo $t7=12/$moist7 *100 .'%';
                          ?>
                         </div>
                     </div> 

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             8ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo8?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_8?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc8?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist8= $moist7-12;
                               echo $t8=12/$moist8 *100 .'%';
                          ?>
                         </div>
                     </div>
                     
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             9ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo9?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_9?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc9?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist9= $moist8-12;
                               echo $t9=12/$moist9 *100 .'%';
                          ?>
                         </div>
                     </div>
                                         
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             10ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo10?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_10?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc10?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist10= $moist9-12;
                               echo $t10=12/$moist10 *100 .'%';
                          ?>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             11ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo11?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_11?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc11?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist11= $moist10-12;
                               echo $t11=12/$moist11 *100 .'%';
                          ?>
                         </div>
                     </div>
                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             12ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo12?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_12?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc12?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist12= $moist11-12;
                               echo $t12=12/$moist12 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                    
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             13ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo13?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_13?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc13?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist13= $moist12-12;
                               echo $t13=12/$moist13 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                          
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             14ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo14?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_14?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc14?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist14= $moist13-12;
                               echo $t14= 12/$moist14 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             15ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo15?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_15?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc15?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist15= $moist14-12;
                               echo $t15=12/$moist15 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                             
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             16ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo16?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_16?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc16?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist16= $moist15-12;
                               echo $t16=12/$moist16 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             17ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo17?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_17?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc17?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist17= $moist16-12;
                               echo $t17=12/$moist17 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                               
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             18ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo18?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_18?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc18?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist18= $moist17-12;
                               echo $t18=12/$moist18 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                                
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             19ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo19?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite19?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_19?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc19?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist19= $moist18-12;
                               echo $t19=12/$moist19 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                            
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             20ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo20?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite20?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_20?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc20?> </h6>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                          <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist20= $moist19-12;
                               echo $t20=12/$moist20 *100 .'%';
                          ?>
                         </div>
                     </div>
                                                      
                     <div class="row">
                         <div class="col-2  pt-1 "style='border:solid gray 0.5px'>
                             21ème Année
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$vo21?>
                         </div>
                         <div class="col-2  pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite21?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <?=$annuite_cumule_21?>
                         </div>
                         <div class="col-2   pt-1"style='border:solid gray 0.5px'>
                         <h6> <?=$vnc21?> </h6>
                         </div>
                         <?php
                               $totalmois=$donnees['dureeS']*12;
                               
                               $moist21= $moist20-12;
                               echo 12/$moist21 *100 .'%';
                          ?>
                         </div>
                     </div><hr>
                 </div>
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