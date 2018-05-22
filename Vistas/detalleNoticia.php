<?php
    
    require_once './cabeza.php';
    require_once "../Controladores/servidorNoticias.php";
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }


   
?>

<div class="container">
<div class="section">
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
          <div class="card-content" id="divCard-content">
            
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
          <div class="input-field col s4 m4 l4 xl4" style="margin-left:10px;margin-right:10px">
            <input placeholder="fijar el tiempo de refresco de la noticia" id="tiempoRefresco" value="5000" name="tiempoRefresco" type="number" class="validate">
            <label for="tiempoRefresco">Fijar el tiempo de refresco de la noticia y comentarios</label>
          </div>
        </div>
        <div class="row">
          <div class="col s12 m12 l12 xl12 ajustarTextoNoticiaParticular">
            <h5>Comentarios</h5>
          </div>
        </div> 
        <div class="row">
          <div class="col s12 m12 l12 xl12">
              <ul class="collapsible" id="collapsible">                            
              </ul>
            </div>                 
          </div>
          <div class="row">
          <div class="col s12 m12 l12 xl12 ajustarTextoNoticiaParticular">
            <h5>Agregar Comentarios</h5>
          </div>
        </div> 
          <div class="row" style="margin-left:10px;margin-right:10px">
          <form class="col s12" id="frmComentarios">
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
            <div class="row">
              <div class="input-field col s12">
                <textarea placeholder="Comentario" class="materialize-textarea" class="validate" id="comentario" name="comentario"></textarea>
                <label for="comentario">Comentario</label>
              </div>
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


  <?php

require_once './pie.php';
?>   


<script>
$(document).ready(function() {
  
  refrescarComentarios();
 
 
 });

setInterval(function(){ 

  
      
  refrescarComentarios();  
  
  Materialize.toast("Comentarios Actualizados", 2000);
  
  }, $("#tiempoRefresco").val());

setInterval(function(){ 

  
  refrescarDetalleNoticia();



Materialize.toast("Noticia Actualizada", 2000);

}, $("#tiempoRefresco").val());

  



  function refrescarComentarios(){

      $.ajax({
              // En data puedes utilizar un objeto JSON, un array o un query string
              data: {"action" : "refrescaComentarios", "noticiaId": $("#noticiaId").val()},
              //Cambiar a type: POST si necesario
              type: "GET",
              // Formato de datos que se espera en la respuesta
              dataType: "json",
              // URL a la que se enviará la solicitud Ajax
              url: '../Controladores/servidorNoticias.php',
          })
          .done(function(data, textStatus, jqXHR ) {
              var comentarios = ""; 

              $.each(data, function(i, n){  

                  var collapsibleHeader = '<div class="collapsible-header"><i class="material-icons">people</i>'+n.nombre+'</div>';
                  
                      
                  if(n.nombre == 'Administrador')
                  {
                    collapsibleHeader = '<div class="collapsible-header"><i class="material-icons">account_circle</i>'+n.nombre+'</div>';
                  }
                  
                  comentarios += '<li>'
                      + collapsibleHeader
                      +'<div class="collapsible-body"><span>'+n.texto+'</span></div>'
                      +'</li>'; 
              
                });

              $('#collapsible').html('');
              
              $('#collapsible').append(comentarios);
              
          })
          .fail(function( jqXHR, textStatus, errorThrown ) {
              if ( console && console.log ) {
                  console.log( "La solicitud a fallado: " +  errorThrown);
              }
          });

  }


   function refrescarDetalleNoticia(){
       $.ajax({
        // En data puedes utilizar un objeto JSON, un array o un query string
        data: {"action" : "refrescarNoticiaParticular", "noticiaId": $("#noticiaId").val()},
        //Cambiar a type: POST si necesario
        type: "GET",
        // Formato de datos que se espera en la respuesta
        dataType: "json",
        // URL a la que se enviará la solicitud Ajax
        url: '../Controladores/servidorNoticias.php',
        })
        .done(function(data, textStatus, jqXHR ) {
            var noticiaParticular = ""; 
          

            noticiaParticular = '<span class="card-title activator ajustarTextoNoticiaDetalle grey-text text-darken-4" contenteditable="false" name="titulo" id="titulo">'+data.titulo+'</span>'
                 + '<p contenteditable="false" name="texto" id="texto" class="ajustarTextoNoticiaDetalle">'+data.texto+'</p>'
                 + '<input type="hidden" id="noticiaId" name="noticiaId" value="'+data.noticiaId+'"/>';

            $('#divCard-content').html('');
            
            $('#divCard-content').append(noticiaParticular);
            
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  errorThrown);
            }
        });

}


</script>