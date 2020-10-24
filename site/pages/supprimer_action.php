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
 if (isset($_GET['id']  ) AND isset($_GET['id_actionnaire']) ) 
 {
   $getid=$_GET['id'];
  echo $id_actionnaire=$_GET['id_actionnaire'];
    {
        $req=$bdd->prepare('DELETE  FROM liberations WHERE id=?');
         $req->execute(array($getid));
           header('Location:visteurs.php?page=detail_actionnaire&id='.$_GET['id_actionnaire']);

    }
  
 }
?>
