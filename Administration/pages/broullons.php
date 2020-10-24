<?php  
    //    la partie inscription
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
                       $inser_img=$bdd->prepare('INSERT INTO administrateurs(nom,email,motdepasse) VALUES(?,?,?)');
                       $inser_img->execute(array($nom,$email,$password));
                       $inser_img=$bdd->prepare('SELECT*FROM administrateurs WHERE email=?');
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
          if (isset($_FILES['monfichier']) AND $_FILES['monfichier']['error'] == 0) 
        {
          if ($_FILES['monfichier']['size'] <= 1000000) 
          {
            $infosfichier = pathinfo($_FILES['monfichier']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
            if (in_array($extension_upload, $extensions_autorisees))
             {
                move_uploaded_file($_FILES['monfichier']['tmp_name'], 'images/' . basename($_FILES['monfichier']['name']));
                $image='images/' . $_FILES['monfichier']['name'];
                

            } else {
                # code...
            }
            
          } else {
              # code...
          }
           
        }

                         <p>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="form-group">
                            <label for="formGroupExampleInput">Image de mon article:</label>
                            <input type="file" name='monfichier' class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder">
                             </div>
                            </div>
                             
                        </div>
                    </p><br>
                    <p><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name='auto' class="custom-control-input" id="customSwitch1">
                                    <label class="custom-control-label" for="customSwitch1">Publier l'article</label>
                                  </div>
                            </div>
                        </div>
                    </p>


                    if (isset($_FILES['monfichier']) AND $_FILES['monfichier']['error'] == 0) 
           {
             if ($_FILES['monfichier']['size'] <= 1000000) 
             {
               $infosfichier = pathinfo($_FILES['monfichier']['name']);
               $extension_upload = $infosfichier['extension'];
               $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
               if (in_array($extension_upload, $extensions_autorisees))
                {
                   move_uploaded_file($_FILES['monfichier']['tmp_name'], 'images/' . basename($_FILES['monfichier']['name']));
                   $image='images/' . $_FILES['monfichier']['name'];
                   $img=$bdd->prepare('UPDATE articles SET images=? WHERE id=?');
                   $img->execute(array($image,$_GET['id']));
                  
                   if (isset($_POST['checkbox']))
                        {
                          echo $_POST['checkbox'];
                          $checkbox=$_POST['checkbox'];
                          $req=$bdd->prepare('UPDATE articles SET publier=? WHERE id=?');
                          $req->execute(array($checkbox,$_GET['id']));
                         
                        
                    }
   
               } else {
                   # code...
               }
               
             } else {
                 # code...
             }
              
           }
           /********************* */
           <?php 
    session_start();
    if ( isset($_SESSION['id']))

    {
        $getid=intval($_SESSION['id']);
            $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
            $req=$bdd->prepare('SELECT *FROM administrateurs WHERE id=?');
            $req->execute(array($getid));
            $info=$req->fetch();
    }
    if (isset($_POST['newpseudo'])) 
    { 
        $newpseudo=htmlspecialchars($_POST['newpseudo']);
        $newpseudolenght=strlen($newpseudo);
         if ($newpseudolenght<=255) {
            $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
            $req=$bdd->prepare('UPDATE administrateurs SET nom=? WHERE id=?');
            $req->execute(array($newpseudo,$_SESSION['id']));
            // la partie de email
            if (isset($_POST['newemail'])) 
            {  
                $newemail=htmlspecialchars($_POST['newemail']);
                $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
                $req=$bdd->prepare('SELECT *FROM administrateurs WHERE email=?');
                $req->execute(array($newemail));
                $emailexist=$req->rowcount();
                if ( $emailexist==0) {
                            $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
                            $req=$bdd->prepare('UPDATE administrateurs SET email=? WHERE id=?');
                            $req->execute(array($newemail,$_SESSION['id']));
                    if (isset($_POST['newpassword']) AND isset($_POST['newpassword2']) ) 
                    {
                       $newpassword=sha1($_POST['newpassword']);
                       $newpassword2=sha1($_POST['newpassword2']);
                       if ($newpassword==$newpassword2)
                        {
                            $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
                            $req=$bdd->prepare('UPDATE administrateurs SET motdepasse=? WHERE id=?');
                            $req->execute(array($newpassword,$_SESSION['id']));
                            
                                ?>
                                <?php
                                // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
                                if (isset($_FILES['monfichier']) AND $_FILES['monfichier']['error'] == 0)
                                {
                                        // Testons si le fichier n'est pas trop gros
                                        if ($_FILES['monfichier']['size'] <= 1000000)
                                        {
                                                // Testons si l'extension est autorisée
                                                $infosfichier = pathinfo($_FILES['monfichier']['name']);
                                                $extension_upload = $infosfichier['extension'];
                                                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                                                if (in_array($extension_upload, $extensions_autorisees))
                                                {
                                                        // On peut valider le fichier et le stocker définitivement
                                                        move_uploaded_file($_FILES['monfichier']['tmp_name'], 'images/' . basename($_FILES['monfichier']['name']));
                                                        $image='images/' . $_FILES['monfichier']['name'];
                                                        $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
                                                        $req=$bdd->prepare('UPDATE administrateurs SET images=? WHERE id=?');
                                                        $req->execute(array( $image,$_SESSION['id']));
                                                        header('Location:admin.php?page=tablaux&id='.$_SESSION['id']);
                                                        
                                                        
                                                }
                                        }
                                }
                                ?>
                                <?php
                       } else {
                           $erreur3='vos mot de passe ne se correspondent pas!';
                       }
                       
                    }
                } else {
                    $erreur2='Cet email existe déja!';
                }
                
            } else {
                # code...
            }
            
           
         } else {
            $erreur='Votre pseudo ne doit pas depasser 255 caractères!';
         }
         
       
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
   
    <link rel="stylesheet" href="../Administration/css/connexion.css">
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
        <div class="container">
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row no-gutters">
            <div class="col-md-4">
            <img src="..." class="card-img" alt="...">
            </div>
            <div class="col-md-8">
            </div>
        </div>
        </div>
        </div>
        </div>
        <script src="../Administration/bootstrap/bootstrap.min.js"></script> 
        <script src="../Administration/bootstrap/jquery-3.5.1.js"></script>
</body>
</html>

       

        
        <form action="" method="POST" enctype="multipart/form-data">
                <p>
                    <div class="row">
                      <div class="col-lg-12">
                          <label for="newpseudo">Votre nom:</label>
                          <br>
                          <?php
                                       if (isset($erreur)) 
                                       {
                                         echo $erreur;
                                       }                   
                                  ?>
                      </div>
                      <div class="col-lg-12">
                          <input type="text" value="<?= $info['nom'] ?>" name="newpseudo" id="newpseudo" required>
                      </div>
                    </div>
                </p>
                <p>
                    <div class="row">
                      <div class="col-lg-12">
                          <label for="newemail">Votre email:</label>
                          <br>
                          <?php
                                       if (isset($erreur2)) 
                                       {
                                         echo $erreur2;
                                       }                   
                                  ?>
                      </div>
                      <div class="col-lg-12">
                          <input type="email" value="<?=$info['email'] ?>" name="newemail" id="newemail" required>
                      </div>
                    </div>
                </p>
                <p>
                    <div class="row">
                      <div class="col-lg-12">
                          <label for="newpassword">Votre mot de passe:</label>
                          <br>
                      </div>
                      <div class="col-lg-12">
                          <input type="password"  name="newpassword" id="newpassword" required>
                      </div>
                    </div>
                </p>
                <p>
                    <div class="row">
                      <div class="col-lg-12">
                          <label for="newpassword2">Confirmez votre mot de passe:</label>
                          <br>
                      </div>
                      <div class="col-lg-12">
                          <input type="password"  name="newpassword2" id="newpassword2" required>
                      </div>
                      <?php
                                       if (isset($erreur3)) 
                                       {
                                         echo $erreur3;
                                       }                   
                                  ?>
                    </div>
                </p>
                <p>
                    <div class="row">
                      <div class="col-lg-12">
                          <label for="monfichier">Ajouter une image:</label>
                          <br>
                      </div>
                      <div class="col-lg-12">
                          <input type="file"  name="monfichier" id="monfichier" required>
                      </div>
                      <?php
                                       if (isset($erreur3)) 
                                       {
                                         echo $erreur3;
                                       }                   
                                  ?>
                    </div>
                </p>
                <p>
                    <input type="submit" value="Valider">
                </p>
        </form>
 
   
           
   
