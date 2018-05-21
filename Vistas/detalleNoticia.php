<?php
    
    require_once './cabeza.php';
    require_once "../Controladores/servidorNoticias.php";
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }


   
?>

<div class="container">
<div class="section">

   


   <?php
              /*$datos =$db->obtenerImagen($_GET['id']);
              $imagen =$datos[0]['imagen']; // Datos binarios de la imagen.
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
                }*/
                
                  //mysql_close($mysqli);
             ?>                 
  
  <!--   Noticia seleccionada   -->
  <div class="row">
    <div class="col s12 m12 l12 xl12">
      <div class="icon-block">

         <div class="card">
          <div class="card-image waves-effect waves-block waves-light">
            <div class="carousel">

              <?php

                  $datos = $db->obtenerImagen($_GET['id']);

                  foreach ($datos as $imagen) {

                      echo '<a class="carousel-item" href="#"><img class="materialboxed" width="650" src="data:image/png;charset=utf8;base64,'.base64_encode($imagen['imagen']).'"></a>';
        
                    }
              ?> 
            </div>
          </div>
          <div class="card-content">
            
            <?php
                  $datos = $db->obtenerNoticias($_GET['id']);
                
                 echo '<span class="card-title activator ajustarTextoNoticiaDetalle grey-text text-darken-4" contenteditable="false" name="titulo" id="titulo">'.$datos[0]['titulo'].'</span>';
                 echo '<p contenteditable="false" name="texto" id="texto" class="ajustarTextoNoticiaDetalle">'.$datos[0]['texto'].'</p>';
                 echo '<input type="hidden" id="noticiaId" name="noticiaId" value="'.$_GET['id'].'"/>';
              ?> 
            
           
          </div>
          <div class="card-action">
          <?php
                if(isset($_SESSION['login_user'])){

                  echo ' <a href="#" id="btnEditarNoticia"><i class="material-icons">edit</i></a>';

                }
               
              ?> 
         
          <a href="#" id="btnAgregarEditarNoticia" class="hide"><i class="material-icons">add</i></a>
          <a href="#" id="btnCancelarEditarNoticia" class="hide"><i class="material-icons">cancel</i></a>
        </div>
        <div class="row">
          <div class="col s12 m12 l12 xl12 ajustarTextoNoticiaDetalle">
            <h5>Comentarios</h5>
          </div>
        </div> 
        <div class="row">
          <div class="col s12 m12 l12 xl12">
              <ul class="collapsible">
                <li>
                  <div class="collapsible-header"><i class="material-icons">account_circle</i>Administrador</div>
                  <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">people</i>Anonimo</div>
                  <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
                </li>               
              </ul>
            </div>                 
          </div>
          <div class="row">
          <div class="col s12 m12 l12 xl12 ajustarTextoNoticiaDetalle">
            <h5>Agregar Comentarios</h5>
          </div>
        </div> 
          <div class="row" style="margin-left:10px;margin-right:10px">
          <form class="col s12">
            <div class="row">
              <div class="input-field col s12">
                <?php
                
                  if(isset($_SESSION['login_user'])){

                    echo '<input placeholder="Nombre" id="nombre" name="nombre" value="Administrador" type="text" disabled class="disable">';

                  }else{

                    echo '<input placeholder="Nombre" id="nombre" name="nombre" type="text" class="validate">';


                  }
                  
                ?>
               
                <label for="nombre">Nombre</label>
              </div>
            </div>
            <div class="row hide">
              <div class="input-field col s12">
                <input placeholder="tiempo" id="tiempo" name="tiempo" type="text" class="validate">
                <label for="tiempo">Nombre</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <textarea placeholder="Comentario" class="materialize-textarea" class="validate" id="comentario" name="comentario"></textarea>
                <label for="comentario">Comentario</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s3">
              <a class="waves-effect waves-light btn blue" id="bntGuardarComentario"><i class="material-icons left">saved</i>Agregar</a>

              </div>              
            </div>      
          </form>        
          </div>
        </div>                 
      </div>
    </div>       
  </div>
</div>
<br>
<br>
</div>

<div class="row">
 <div class="col s12 m12 l12 xl12">
    <?php

         require_once './pie.php';
      ?>
 </div>
     
</div>      
