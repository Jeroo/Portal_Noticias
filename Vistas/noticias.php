<?php
    
    require_once './cabeza.php';
    //require_once '../modelos/conexion.php';
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['login_user'])) { //not logged in

        //redirect to homepage
        header("Location: ../index.php");
        die();

    }
?>
<div class="row" style="width: 50%">
  
<div class="col s12 m12 l12 xl12">
      
<ul id="slide-out" class="side-nav">
<li><div class="user-view">
  <div>
    <img src="../resources/img/logo.PNG" alt=""/>
  </div>
 
</div></li>
<li><a href="#!"><i class="material-icons">menu</i>Menú</a></li>

<li><div class="divider"></div></li>
<li><a class="subheader"><i class="material-icons">home</i>Inicio</a></li>
<li>
<li>
    <a class="waves-effect" href="../controladores/ControladorCarrito.php?action=reporte1"><i class="material-icons">assignment</i>Listado de todos los libros</a>     

</li>
 <li>
    <a class="waves-effect"><i class="material-icons">assignment</i>Listado con el libro recomendado en ese momento</a>
  

</li>
  <li>
    <a class="waves-effect"><i class="material-icons">assignment</i>Número total de libros vendidos</a>
  

</li>
</ul>
<a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
      
  </div>
      
  
</div>

<div class="container">
<div class="section">

  <!--   Icon Section   -->
  <div class="row">
    <div class="col s12 m12 l12 xl12">
      <div class="icon-block">
        <h2 class="center light-blue-text"><i class="material-icons">view_list</i></h2>
        <h5 class="center">Listado de Libros en venta</h5>
        
        <a class="btn-floating btn-large waves-effect waves-light red" href="agregar.php"><i class="material-icons">add</i></a>
        <table id="listaLibros" cellspacing="0" width="100%" class="striped highlight centered responsive-table display">
            <thead>
              <tr>
                  <th>Portada</th>
                  <th>Id</th>
                  <th>Título</th>
                  <th>Autor</th>
                  <th>Editorial</th>
                  <th>Año Públicación</th>
                  <th>Formato</th>
                  <th>Categoria</th>
                  <th>Precio</th>
                  <th>Libro Recomendado</th>
                  <th>Cantidad Stock</th>
                  <th>Acciones</th>
              </tr>
            </thead>  

            <tbody>
            <?php
              
              $sql = "SELECT l.id, f.formato,c.categoria,l.titulo,l.autor,l.editorial,l.aniopublicacion,l.precio,l.cantidadstock,l.librorecomendado  FROM libros l left join categorias c on c.id=l.idcategoria left join formatos f on f.id=l.idformato;";
              $resultado = mysqli_query($mysqli,$sql);
              
              if($resultado)
                {

                   while($row = mysqli_fetch_array($resultado))
                    {

                       echo '<tr><td align="left">' .
                                "<img src=\"../resources/img/$row[id].jpg\" alt=\"Portada del libro $row[titulo]\" height='80' width='80'></td><td align='left'>" .
                                $row['id'] . '</td><td align="left">' .
                                $row['titulo'].  '</td><td align="left">' .
                                $row['autor'] . '</td><td align="left">'.
                                $row['editorial'] . '</td><td align="left">'.
                                $row['aniopublicacion'].  '</td><td align="left">'.
                                $row['formato'].  '</td><td align="left">'.
                                $row['categoria'].  '</td><td align="left">'.
                                $row['precio'].  ' &euro;</td><td align="left">'.
                                ($row['librorecomendado'] == 1 ? "Sí" : "No").  '</td><td align="left">'.
                                $row['cantidadstock']. 
                                "<td><a href=\"modificar.php?id=$row[id]\">Modificar</a> | <a href=\"../controladores/ControladorBorrar.php?id=$row[id]\" onClick=\"return confirm('Esta seguro que quiere borrar este libro?')\">Borrar</a></td>"
                               ;


                       echo '</tr>';
                    }

                  }
                else
                {
                    echo "no se puedo ejecutar la consulta hay un error en la base de datos<br />";
                    echo mysqli_error($mysqli);
                }
                
                  //mysql_close($mysqli);
             ?>                         
            
            </tbody>
          </table>          
      </div>
    </div>       
  </div>
</div>
<br>
<br>
</div>

<div class="row hide">
 <div class="col s12 m12 l12 xl12">
    <?php

         require_once './pie.php';
      ?>
 </div>
     
</div>      
