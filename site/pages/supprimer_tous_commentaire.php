<?php
 if (isset($_GET['id'])  && isset($_GET['id_publications']) ) {
     $getid=$_GET['id'];
     $id_pu = $_GET['id_publications']; 
     $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
     $select=$bdd->prepare('SELECT* FROM commentaires WHERE id=?');
     $select->execute(array($getid));
     
     $bdd=new PDO('mysql:host=localhost; dbname=w&k;charset=utf8','root','');
     $supprimer=$bdd->prepare('DELETE FROM commentaires WHERE id=?');
     $supprimer->execute(array($getid));
     header("Location:visteurs.php?page=tous_les_commentaires&id_publications=".$id_pu);
 }

?>