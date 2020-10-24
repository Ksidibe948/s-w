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
   $select=$bdd->prepare('SELECT * FROM ventes WHERE id=? ORDER BY id DESC ');
   $select->execute(array($getid));
   $doonnees=$select->fetch();
   
   ?>
<?php
 if (isset($_GET['id'] ) ) 
 {
   $getid=$_GET['id'];
    {
        $req=$bdd->prepare('DELETE  FROM ventes WHERE id=?');
         $req->execute(array($getid));

    }
    header('Location:visteurs.php?page=vente_marchandise&id='.$doonnees['id']);
 }
?>