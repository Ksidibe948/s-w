<!-- la partie php -->
<?php  
        session_start();
        if ( isset($_GET['id'])) {
            $getid=intval($_GET['id']);
            $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
            $req=$bdd->prepare('DELETE FROM articles WHERE id =?');
            $req->execute(array($getid));
            header('Location:admin.php?page=publier_articles&id='.$_SESSION['id']);
        } else {
           
        }

  