<!-- la partie php -->
    <?php  
    //    la partie inscription
      session_start();
       if (isset($_POST['nom']) AND isset($_POST['email']) AND isset($_POST['password']) AND isset($_POST['password2'])) {
           $nom=htmlspecialchars($_POST['nom']);
           $email=htmlspecialchars($_POST['email']);
           $password=sha1($_POST['password']);
           $password2=sha1($_POST['password2']);
           $nomlenght=strlen($nom);
           if ($nomlenght<=255){
               $bdd=new PDO ('mysql:host=localhost;dbname=w&k; charset=utf8','root','');
               $selection_donnees_administrateur=$bdd->prepare('SELECT * FROM administrateurs WHERE email=?');
               $selection_donnees_administrateur->execute(array($email));
               $email_administrateurexist=$selection_donnees_administrateur->rowcount();
               if ($email_administrateurexist==0)
                {
                   if ($password==$password2) {
                       $insertion_desdonnes_administrateur=$bdd->prepare('INSERT INTO administrateurs(nom,email,motdepasse) VALUES(?,?,?)');
                       $insertion_desdonnes_administrateur->execute(array($nom,$email,$password));
                       $recuperation_donnees_administrateurs=$bdd->prepare('SELECT*FROM administrateurs WHERE email=?');
                       $recuperation_donnees_administrateurs->execute(array($email));
                       $administrateur_info=$recuperation_donnees_administrateurs->fetch();
                       $_SESSION['id']=$administrateur_info['id'];
                       $_SESSION['nom']=$administrateur_info['nom'];
                       $_SESSION['email']=$administrateur_info['email'];
                       $_SESSION['motdepasse']=$administrateur_info['motdepasse'];
                       $_SESSION['images']=$administrateur_info['images'];
                       $_SESSION['date_inscription']=$administrateur_info['date_inscription'];
                       header('Location:admin.php?page=tablaux&id='.$_SESSION['id']);
                       
                       

                   } else {
                       $erreur3='Vos mots de passes ne se correspondent pas!';
                   }
                   
               } else {
                   $erreur2='Cet email est déja utilisé!';
               }
               
           } else {
               $erreur1='Votre pseudo ne doit pas depasser 255 caractères!';
           }
           
       }
    ?>
    <!-- la partion connexion -->
      <?php 
          if (isset($_POST['newemail']) AND isset($_POST['newpassword']))
        {     
            $newemail=htmlspecialchars($_POST['newemail']);
            $newpassword=sha1($_POST['newpassword']);
            $bdd=new PDO ('mysql:host=localhost;dbname=w&k; charset=utf8','root','');
            $req=$bdd->prepare('SELECT * FROM administrateurs WHERE email=? AND motdepasse=?');
            $req->execute(array($newemail,$newpassword));
            $info=$req->fetch();
            
            if ($newemail=$info['email']) 
            { 
                $_SESSION['id']=$info['id'];
                 $_SESSION['email']=$info['email'];
                $_SESSION['nom']=$info['nom'];
                $_SESSION['motdepasse']=$info['motdepasse'];
                $_SESSION['images']=$info['images'];
                $_SESSION['date_inscription']=$info['date_inscription'];
                header('Location:admin.php?page=tablaux&id='.$_SESSION['id']);

            } else {
               $error='Mauvais email ou mauvais mot de passer!';
            }
            
          }
         ?>
    
<!-- la partie html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../Administration/css/connect.css">
    <link rel="stylesheet" href="../Administration/bootstrap/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand ml-5" href="#">w&k</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    </div>
    </nav>
     <br>
    <div class="container">
      <div class="row">
      <div class="col-lg-2"></div>
        <div class="col-lg-4 inscription">
            <p class='form-titre'>Inscription:</p>
            <form action="" method="POST" enctype="multipart/form-data">
                    <p>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="form-group">
                            <label for="formGroupExampleInput"> Votre pseudo:</label>
                             <?php
                                       if (isset($erreur1)) 
                                       {
                                           ?>
                                         <div class="erreur text-danger"><?php echo $erreur1;?> </div>
                                         <?php
                                       }                   
                                  ?>
                            <input type="text" name="nom" class="form-control" id="formGroupExampleInput" placeholder="Example jean" required>
                             </div>
                            </div>
                        </div>
                    </p>
                    <p>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="form-group">
                            <label for="formGroupExampleInput"> Votre email:</label>
                             <?php
                                       if (isset($erreur2)) 
                                       {
                                           ?>
                                         <div class="erreur text-danger"><?php echo $erreur2;?> </div>
                                         <?php
                                       }                   
                                  ?>
                            <input type="email" name="email"  class="form-control" id="formGroupExampleInput" placeholder="Example jean@gmail.com" required>
                             </div>
                            </div>
                        </div>
                    </p>
                    <p>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="form-group">
                            <label for="formGroupExampleInput"> Votre mot de passe:</label>
                             <?php
                                       if (isset($erreur3)) 
                                       {
                                           ?>
                                         <div class="erreur text-danger"><?php echo $erreur3;?> </div>
                                         <?php
                                       }                   
                                  ?>
                            <input type="password" name="password"  class="form-control" id="formGroupExampleInput"  required>
                             </div>
                            </div>
                        </div>
                    </p>
                    <p>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="form-group">
                            <label for="formGroupExampleInput"> Confirmer votre mot de passe:</label>
                             <?php
                                       if (isset($erreur3)) 
                                       {
                                           ?>
                                         <div class="erreur text-danger"><?php echo $erreur3;?> </div>
                                         <?php
                                       }                   
                                  ?>
                            <input type="password" name="password2"  class="form-control" id="formGroupExampleInput"  required>
                             </div>
                            </div>
                        </div>
                    </p>
                    <p>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="form-group">
                            <input type="submit" value="Je m'inscris" class='submit'>
                             </div>
                            </div>
                        </div>
                    </p>
                
            </form>
           </div>
           <div class="col-lg-2"></div>
            <div class="col-lg-4 connexion">
            <p class='form-titre'>Connexion:</p>
            <form action="" method="POST" enctype="multipart/form-data">
                     <p>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="form-group">
                            <label for="formGroupExampleInput"> Votre email:</label>
                            <input type="email" name="newemail"  class="form-control" id="formGroupExampleInput" placeholder="Example jean@gmail.com" required>
                             </div>
                            </div>
                        </div>
                    </p>
                    <p>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="form-group">
                            <label for="formGroupExampleInput"> Votre mot de passe:</label>
                            <input type="password" name="newpassword"   class="form-control" id="formGroupExampleInput"  required>
                             </div>
                            </div>
                        </div>
                    </p>
                                 <?php
                                       if (isset($error)) 
                                       {
                                           ?>
                                         <div class="erreur text-danger"><?php echo $error;?> </div>
                                         <?php
                                       }                   
                                  ?>
                <p>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="form-group">
                            <input type="submit" value="Je me connecte" class='submit'>
                             </div>
                            </div>
                        </div>
                    </p>
            </form>
        </div>
     </div>
    </div> 
   <script src="../Administration/bootstrap/bootstrap.min.js"></script> 
   <script src="../Administration/bootstrap/jquery-3.5.1.js"></script>
</body>
</html>