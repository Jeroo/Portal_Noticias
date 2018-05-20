<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require("./Controladores/servidorNoticias.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>NOTICIAS</title>
  <link rel="shortcut icon" type="image/png" href="recursos/img/logonoticias.PNG"/>
  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="./recursos/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>  
  <link href="./recursos/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
  <link href="./recursos/css/animate.css" rel="stylesheet" type="text/css"/>

  <link href="./recursos/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  
</head>
<body>

  
  <nav class="red lighten-1" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="../index.php" class="brand-logo">NOTICIAS</a>
      <ul class="right hide-on-med-and-down">
        
       <?php
       
         if (!isset($_SESSION['login_user'])) { //not logged in

                 echo "<li><a href='./vistas/login.php'><i class='material-icons'>account_circle</i></a></li>";

            }else {
                
                $login = $_SESSION['login_user'];
                echo "<li><a href='#'>$login</a></li>";

            }
       ?>
       
        <li><a href="./Controladores/servidorNoticias.php?action=logout"><i class="material-icons">exit_to_app</i></a></li>
      
        
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
        <li><a href="#"><i class="material-icons">exit_to_app</i></a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>

  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
    <a class="btn-floating btn-large waves-effect waves-light red tooltipped modal-trigger" href="#noticiaModal" data-position="bottom" data-tooltip="Presione para agregar una nueva noticia"><i class="material-icons">add</i></a>
      <h1 class="header center orange-text animated bounceInDown"> 
        <img src="./recursos/img/logonoticias.PNG" alt=""/></h1>
      <div class="row center">
        <h5 class="header col s12 light hide">Portal de NOTICIAS</h5>
      </div>
      <div class="row center">

  

        <img src="./Controladores/servidorNoticias.php?id=2" class="hide" />

        <section class="noticias hide">
                <section class="slider_noticias">

                          <div class="banner">
                            <img src="recursos/img/9.jpg" alt="" class="slide">
                            <img src="recursos/img/10.jpg" alt="" class="slide">
                            <img src="recursos/img/11.jpg" alt="" class="slide">
                          </div>
                          <a href="#" id="banner-prev" class="flecha-banner anterior"><span class="fa fa-chevron-left"></span></a>
                          <a href="#" id="banner-next" class="flecha-banner siguiente"><span class="fa fa-chevron-right"></span></a>
                </section>
          </section>
        <div class="contenedor animated bounceInLeft" id="contenedor">
         
        </div>
      </div>
      
      <div class="row center hide">
         <h2 class="center light-blue-text"><i class="material-icons">group</i></h2>
         <a href="./vistas/noticias.php" id="download-button" class="btn-large waves-effect waves-light orange">
        
           
            <h5 class="center">Ir a las Noticias</h5>
        
        </a>
         <?php
       
         if (!isset($_SESSION['login_user'])) { //not logged in

                echo "<a href='./vistas/login.php' id='download-button' class='btn-large waves-effect waves-light orange'><h5 class='center'>Registrarse</h5></a>";

            }else {
                
                 echo "<a href='./vistas/administracion.php' id='download-button' class='btn-large waves-effect waves-light orange'><h5 class='center'>Administrador</h5></a>";


            }
       ?>
         
      </div>
    

    </div>
    

  </div>

 <footer class="page-footer red lighten-1 footer">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">NOTICIAS</h5>
          <p class="grey-text text-lighten-4">
              
              Portal de ventas NOTICIAS, donde podra estar enterado de todo el acontecer noticioso.
              
          </p>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text">NOTICIAS</h5>
          <ul>
            <li><a class="white-text" href="#!">NOTICIAS DESTACADAS</a></li>
            <li><a class="white-text" href="#!">NOTICIAS MAS VISTAS</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Copyright © 2018 NOTICIAS, Todos los derechos reservados.
      </div>
    </div>
  </footer>

    <!-- Modal Structure -->
  <div id="noticiaModal" class="modal">
      <div class="modal-content">
        <h4>Agregar una nueva Noticia</h4>
        <div class="row">
          <form class="col s12">
            <div class="row">
              <div class="input-field col s12">
                <input placeholder="Titulo noticia" id="titulo" name="titulo" type="text" class="validate">
                <label for="titulo">Titulo</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <textarea placeholder="Texto noticia" class="materialize-textarea" class="validate" id="texto"></textarea>
                <label for="texto">Texto Noticia</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s3">
              <a class="waves-effect waves-light btn blue" id="bntGuardarNoticia"><i class="material-icons left">saved</i>Agregar</a>

              </div>
              <div class="input-field col s6">
              <a class="waves-effect waves-light btn red" id="bntLimpiarGuardarNoticia"><i class="material-icons left">delete</i>Limpiar</a>

              </div>
            </div>      
          </form>
          <div class="row" style="margin-top:100px">
              <div class="input-field col s12">
                <form action="./Controladores/servidorNoticias.php" method="POST" enctype="multipart/form-data">
                    <h5>Cargar imagenes a la noticia agregada:</h5>
                    <input type="hidden" name="action" id="action" value="cargarImagen" />
                    <input type="file" name="imagen" id="imagen" />
                    <input type="submit" name="subir" id="subir" value="Subir Imagen"/>
                </form>
              </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
      </div>
  </div>

  <!--  Scripts-->
  <script src="./recursos/js/jquery-2.1.1.min.js"></script>
  <script src="./recursos/js/materialize.js"></script>
  <script src="./recursos/js/init.js"></script>
  <script src="./recursos/js/appScript.js"></script>


  </body>
</html>