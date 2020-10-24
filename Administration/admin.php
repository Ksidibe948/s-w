<!-- la partie php -->
    <?php
          $pages=scandir('pages/');
          if (isset($_GET['page'])  AND !empty($_GET['page'])) 
          {
                   if (in_array($_GET['page'].'.php' ,$pages)) {
                      $page=$_GET['page'];
                   } else {
                       $page='erreurs';
                   }
                   
          } else {
              $page='connexion';
          }
          
          ?>
<!-- la partie html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../Administration/bootstrap/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php  include 'pages/'.$page.'.php' ?>
 
   <script src="../Administration/bootstrap/bootstrap.min.js"></script> 
   <script src="../Administration/bootstrap/jquery-3.5.1.js"></script>
</body>
</html>