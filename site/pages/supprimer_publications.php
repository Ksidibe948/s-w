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
 if (isset($_GET['id'] ) ) 
 {
    $getid=$_GET['id'];
    $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
    $req=$bdd->prepare('SELECT * FROM publications WHERE id_publications=?');
    $req->execute(array($getid));
    $exist=$req->rowcount();
    if ($exist==1) 
    {
        $req=$bdd->prepare('DELETE  FROM publications WHERE id_publications=?');
         $req->execute(array($getid));

         $req1=$bdd->prepare('DELETE  FROM commentaires WHERE id_publications=?');
         $req1->execute(array($getid));

         $req2=$bdd->prepare('DELETE  FROM    dislike WHERE id_publications=?');
         $req2->execute(array($getid));

         $req3=$bdd->prepare('DELETE  FROM     likes WHERE id_publications=?');
         $req3->execute(array($getid));
        

    }
    header('Location:visteurs.php?page=donnees_utilisateurs&id='.$_SESSION['id']);
 }
?>