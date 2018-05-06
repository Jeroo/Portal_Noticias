<?php

   
   if (session_status() == PHP_SESSION_NONE) {
         session_start();
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>NOTICIAS</title>
  
  <link rel="shortcut icon" type="image/png" href="../recursos/img/logonoticias.PNG"/>
  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="../recursos/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../recursos/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../recursos/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
  <link href="../recursos/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
  <nav class="red lighten-1" role="navigation">
    <div class="nav-wrapper container">
        <a id="logo-container" href="../index.php" class="brand-logo">NOTICIAS</a>
      <ul class="right hide-on-med-and-down">
         <?php
       
         if (!isset($_SESSION['login_user'])) { //not logged in

                 echo "<li><a href='login.php'><i class='material-icons'>account_circle</i></a></li>";

            }else {
                
                $login = $_SESSION['login_user'];
                echo "<li><a href='#'>$login</a></li>";

            }
       ?>
    
        
        <li><a href="../controladores/ControladorLogOut.php"><i class="material-icons">exit_to_app</i></a></li>

      
        
      </ul>
        

      <ul id="nav-mobile" class="side-nav">
           <?php
       
         if (!isset($_SESSION['login_user'])) { //not logged in

                 echo "<li><a href='#'><i class='material-icons'>account_circle</i></a></li>";

            }else {
                
                $login = $_SESSION['login_user'];
                echo "<li><a href='#'>$login</a></li>";

            }
       ?>
        <li><a href="#"><i class="material-icons">shopping_cart</i></a></li>
        <li><a href="#"><i class="material-icons">exit_to_app</i></a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
