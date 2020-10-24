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
                                }else {
                                   $erreur4='Ajouter une image!';
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
        <div class="card mb-3" style="max-width: px;">
        <div class="row no-gutters">
            <div class="col-md-4">
            <?="<img src='".$info['images']."' class='d-block w-100 h-90' >" ;?>
            </div>
            
            <div class="col-md-6 ml-2">
                 
           <form action="" method="POST" enctype="multipart/form-data">
                
                    <p>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="form-group">
                            <label for="formGroupExampleInput"> Votre nom:</label>
                             <?php
                                       if (isset($erreur)) 
                                       {
                                           ?>
                                         <div class="erreur text-danger"><?php echo $erreur;?> </div>
                                         <?php
                                       }                   
                                  ?>
                            <input type="text" value="<?= $info['nom'] ?>" name="newpseudo" class="form-control" id="formGroupExampleInput" placeholder="Example Finance" required>
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
                            <input type="email" value="<?=$info['email'] ?>" name="newemail" class="form-control" id="formGroupExampleInput" placeholder="Example Finance" required>
                             </div>
                            </div>
                        </div>
                    </p>
                    <p>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="form-group">
                            <label for="formGroupExampleInput"> Votre Mot de passe:</label>
                            <?php
                                       if (isset($erreur3)) 
                                       {
                                           ?>
                                         <div class="erreur text-danger"><?php echo $erreur3;?> </div>
                                         <?php
                                       }                   
                                  ?>
                            <input type="password"  name="newpassword" class="form-control" id="formGroupExampleInput"  required>
                             </div>
                            </div>
                        </div>
                    </p>
                    <p>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="form-group">
                            <label for="formGroupExampleInput"> Confirmer votre de passe:</label>
                            <input type="password"  name="newpassword2" class="form-control" id="formGroupExampleInput" required>
                             </div>
                            </div>
                        </div>
                    </p>
                    <p>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="form-group">
                            <label for="formGroupExampleInput"> Ajouter une image:</label>
                             <div class="erreur">
                             <?php
                                       if (isset($erreur3)) 
                                       {
                                           ?>
                                         <div class="erreur text-danger"><?php echo $erreur3;?> </div>
                                         <?php
                                       }                   
                                  ?>
                             </div>
                            <input type="file"  name="monfichier" class="form-control" id="formGroupExampleInput"  required>
                             </div>
                            </div>
                        </div>
                    </p>
                    <p>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="form-group">
                            <input type="submit" value='Modifier' class='submit'>
                             </div>
                            </div>
                        </div>
                    </p>
           </form>
            </div>
        </div>
        </div>
        </div>
        <script src="../Administration/bootstrap/bootstrap.min.js"></script> 
        <script src="../Administration/bootstrap/jquery-3.5.1.js"></script>
</body>
</html>