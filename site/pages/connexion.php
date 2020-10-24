<?php
  session_start();
   $bdd=new PDO ('mysql:host=localhost;dbname=w&k; charset=utf8','root','');
    if (isset($_POST['pseudo']) AND isset($_POST['email']) AND isset($_POST['password']) AND isset($_POST['password2']) ) {
       $pseudo=htmlspecialchars($_POST['pseudo']);
       $email=htmlspecialchars($_POST['email']);
       $password1=sha1($_POST['password']);
       $password2=sha1($_POST['password2']);
       $pseudolenght=strlen($pseudo);
        if ($pseudolenght<=255) 
        {  
           $req=$bdd->prepare('SELECT *FROM utilisateurs WHERE email=?');
           $req->execute(array($email));
           $emailexist=$req->rowcount(); 
          if ($emailexist==0) {
            if ($password1==$password2) {
                $bdd=new PDO ('mysql:host=localhost;dbname=w&k; charset=utf8','root','');
                $new=$bdd->prepare('INSERT INTO utilisateurs (nom,email,password)VALUES(?,?,?)');
                $new->execute(array($pseudo,$email,$password2));
                $bdd=new PDO ('mysql:host=localhost;dbname=w&k; charset=utf8','root','');
                $req=$bdd->prepare('SELECT *FROM utilisateurs WHERE email=?');
                $req->execute(array($email));
                $info=$req->fetch();
                $_SESSION['id']=$info['id'];
                $_SESSION['email']=$info['email'];
                $_SESSION['nom']=$info['nom'];
                $_SESSION['images']=$info['images'];
                $_SESSION['date']=$info['date'];
                header('Location:visteurs.php?page=utilisateurs&id='.$_SESSION['id']);
            } else {
                $error3='Vos mot de passes ne se correspondent pas!';
            }
          } else {
             $error2='Cet email existe déja!';
          }
          
            
        } else {
           $error1='Votre pseudo ne doit pas depasser 255 caractères!';
        }
        
    }

?>
 <!-- la partie de connexion -->
 <?php 
          if (isset($_POST['newemail']) AND isset($_POST['newpassword']))
        {     
           $newemail=htmlspecialchars($_POST['newemail']);
           $newpass=sha1($_POST['newpassword']);
           $select=$bdd->prepare('SELECT * FROM utilisateurs WHERE email=? AND password=?');
           $select->execute(array($newemail,$newpass));
           $emailexist=$select->rowcount();
           $donnees=$select->fetch();
           echo $donnees['id'];
           if ($emailexist==1) {
             $_SESSION['id']=$donnees['id'];
             $_SESSION['email']=$donnees['email'];
             $_SESSION['password']=$donnees['password'];
             $_SESSION['images']=$donnees['images'];
             $_SESSION['date']=$donnees['date'];
             header('Location:visteurs.php?page=utilisateurs&id='.$_SESSION['id']);
           } else {
               $error5='Mauvais compte ou mauvais mot de passe!';
           }
           
            
          }
         ?>
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
        <nav class=" col shadow-lg navbar navbar-expand-lg navbar-dark bg-success" style='height:50px'>
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
      
    </div>
    </div>
    </nav>
        </div>
    </div>
</div>
<div class='bg-'>
    <div class="container">
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
      <strong>Bonjour!</strong>Bienvenue sur la page de connexion
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    </div>
     <div class="container">
         <div class="row">
                            <!-- la partie inscription -->
                            <div class="col-lg-3"></div>
                            <div class="col-lg-4">
                            <div class="card shadow-lg" style="width: 18rem; ">
                            <div class="card-body">
                                <h5 class="card-title text-center">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7.5-3a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                                </svg>
                              Créer un compte
                                </h5>
                                <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Votre Pseudo:</label><br>
                                    <?php if (isset($error1)) 
                                            {
                                                ?>
                                         <span class="text-danger"> <?= $error1?></span>
                                            <?php
                                            }
                                            ?>
                                    <input type="text" name="pseudo" class="form-control" id="formGroupExampleInput" placeholder="Example Jean" required>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Votre email:</label><br>
                                    <?php if (isset($error2)) 
                                            {
                                                ?>
                                          <span class="text-danger"> <?= $error2
                                          ?></span>
                                            <?php
                                            }
                                            ?>
                                    <input type="email" name="email" class="form-control" id="formGroupExampleInput" placeholder="Example Jean@gmail.com" required>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Votre mot de passe:</label>
                                    <input type="password" name="password" class="form-control" id="formGroupExampleInput" required>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Confirmer votre mot de passe:</label>
                                    <input type="password" name="password2" class="form-control" id="formGroupExampleInput" required>
                                    <?php if (isset($error3)) 
                                            {
                                                ?>
                                           <span class="text-danger"> <?= $error3?></span>
                                            <?php
                                            }
                                            ?>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class='bg-success text-white' value="Je m'inscris" style='margin-left:80px'>
                                </div>
                                </form>
                            </div>
                            </div>
                         </div>
                          <!-- la partie connexion -->
                         <div class="col-lg-4">
                            <div class="card shadow-lg" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title text-center">                    
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        </svg>
                                    Se connexion
                                </h5>
                                <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Votre email:</label><br>
                                    <?php if (isset($error4)) 
                                            {
                                                ?>
                                           <span class="text-danger"> <?= $error4?></span>
                                            <?php
                                            }
                                            ?>
                                    <input type="email" name="newemail" class="form-control" id="formGroupExampleInput" placeholder="Example Jean@gmail.com" required>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Votre mot de passe:</label><br>
                                    <?php if (isset($error5)) 
                                            {
                                                ?>
                                           <span class="text-danger"> <?= $error5?></span>
                                            <?php
                                            }
                                            ?>
                                    <input type="password" name="newpassword" class="form-control" id="formGroupExampleInput" required>
                                <div class="form-group">
                                    <span ><input type="submit" value="Je m'inscris" class='bg-success text-white mt-2' style='margin-left:80px'></span>
                                </div>
                                </form>
                            </div>
                            </div>
                         </div>
         </div>
     </div>
    <script src="../Administration/bootstrap/bootstrap.min.js"></script>
    <script src="../Administration/bootstrap/jquery-3.5.1.js"></script>
</body>
</html>