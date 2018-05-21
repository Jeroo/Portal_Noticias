var tiempoDeRefresco = 60000;
var url = "./Controladores/servidorNoticias.php";

$(document).ready(function() {
    $('.modal').modal();
    $('.carousel').carousel();
    $('.collapsible').collapsible();
    /**
     * 
     * Inicializar noticias
     */    
  
    refrescarNoticias(); 
     
     
     //Guardar la Noticia
     $('#bntGuardarNoticia').click(function(e){
      
        e.preventDefault();

        var texto = $('#texto');
        var titulo = $('#titulo');

        if(texto.val() != "" && titulo.val() != ""){

            $.ajax({
                // En data puedes utilizar un objeto JSON, un array o un query string
                data: {"action" : "agregarNoticia", "texto": texto.val(), "titulo": titulo.val()},
                //Cambiar a type: POST si necesario
                type: "POST",
                // Formato de datos que se espera en la respuesta
               // dataType: "json",
                // URL a la que se enviará la solicitud Ajax
                url: url,
            })
             .done(function(data, textStatus, jqXHR ) {                              
              

              if(data > 0){
  
                $('body').append("<input id='idNoticia' name='idNoticia' type='hidden' value='"+data+"'>")

                alert("Noticia Agregada correctamente");
                $('#texto').val('');
                $('#titulo').val('');
                $('#imagenesDiv').removeClass("hide");
                

              }else{              
                Materialize.toast("Hubo un error al agregar la noticia. favor contacte al administracion del sistema", 4000); 
              }
                
             })
             .fail(function(jqXHR, textStatus, errorThrown ) {
                 if (console && console.log ) {
                     console.log( "La solicitud a fallado: " +  textStatus);
                 }
            });


        }else{

            Materialize.toast("debe completar los campos antes de guardar!", 4000); 
        }

       
   
    });  

    $('#bntLimpiarGuardarNoticia').click(function(e){

        titulo = $('#titulo');
        texto = $('#texto');

        titulo.val('');
        texto.val('');
        $('#imagenesDiv').addClass("hide");
        
    });

   
    $('#tiempoRefresco').change(function(e){

        ///alert("cambio: "+modificarTiempoRefresco());    
        modificarTiempoRefresco();    
        
       
    });

    $('#btnEditarNoticia').click(function(e){

        titulo = $('#titulo');
        texto = $('#texto');
        $('#btnAgregarEditarNoticia').removeClass('hide');
        $('#btnCancelarEditarNoticia').removeClass('hide');


        titulo.attr("contenteditable","true");
        texto.attr("contenteditable","true");
        
    });

    $('#btnCancelarEditarNoticia').click(function(e){

        titulo = $('#titulo');
        texto = $('#texto');
        $('#btnAgregarEditarNoticia').addClass('hide');
        $('#btnCancelarEditarNoticia').addClass('hide');


        titulo.attr("contenteditable","false");
        texto.attr("contenteditable","false");
        
    });


    $( "#titulo,#texto" ).blur(function() {
        ModificarNoticia();
      });

    $('#btnAgregarEditarNoticia').click(function(e){

      ModificarNoticia();
        
    });


    $("#frmComentarios").keypress(function(e) {

        if(e.which == 13) {
            
        var nombre = $('#nombre');
        var texto = $('#comentario');
        var noticiaId = $('#noticiaId');

        if(texto.val() != "" && noticiaId.val() != ""){

            $.ajax({
                // En data puedes utilizar un objeto JSON, un array o un query string
                data: {"action" : "nuevoComentario", "nombre": nombre.val() != '' ?  nombre.val() : "Anónimo", "texto": texto.val(),"noticiaId":noticiaId.val()},
                //Cambiar a type: POST si necesario
                type: "POST",
                // Formato de datos que se espera en la respuesta
               // dataType: "json",
                // URL a la que se enviará la solicitud Ajax
                url: "../Controladores/servidorNoticias.php",
            })
             .done(function(data, textStatus, jqXHR ) {
                              
             console.log(data)
              if(data == "true"){
              
                Materialize.toast("Comentario agregado correctamente", 4000);     
                var collapsibleHeader = '<div class="collapsible-header"><i class="material-icons">people</i>'+nombre.val() != '' ?  nombre.val() : "Anónimo"+'</div>';
             
                
                if($('#login').text() != '')
                {
                  collapsibleHeader = '<div class="collapsible-header"><i class="material-icons">account_circle</i>'+$('#nombre').val()+'</div>';
                }


                var comentarioFila = '<li>'
                + collapsibleHeader
                +'<div class="collapsible-body"><span>'+$('#comentario').val()+'</span></div>'
                +'</li>';  
                $('#collapsible').append(comentarioFila);
                $('#comentario').val(''); 
                

              }else{

                Materialize.toast("Hubo un Error no se pudo agregar el comentario", 4000);     
                
              }
                
             })
             .fail(function(jqXHR, textStatus, errorThrown ) {
                 if (console && console.log ) {
                     console.log( "La solicitud a fallado: " +  textStatus);
                 }
            });


        }else{

            Materialize.toast("Debe completar los campos!", 4000);  
   
        }
        }
    });

    $('#btn_login').click(function(e){
      
        e.preventDefault();

        var usuario = $('#usuario');
        var password = $('#password');

        if(usuario.val() != "" && password.val() != ""){

            $.ajax({
                // En data puedes utilizar un objeto JSON, un array o un query string
                data: {"action" : "autenticar", "password": password.val(), "usuario": usuario.val()},
                //Cambiar a type: POST si necesario
                type: "POST",
                // Formato de datos que se espera en la respuesta
               // dataType: "json",
                // URL a la que se enviará la solicitud Ajax
                url: "../Controladores/servidorNoticias.php",
            })
             .done(function(data, textStatus, jqXHR ) {
                              
             
              if(data == "true"){

                Materialize.toast("Usuario Autenticado!", 4000);  
                window.location ='../index.php';

              }else{

                Materialize.toast("Usuario o clave incorrecto", 4000);  
              }
                
             })
             .fail(function(jqXHR, textStatus, errorThrown ) {
                 if (console && console.log ) {
                     console.log( "La solicitud a fallado: " +  textStatus);
                     
                      Materialize.toast("La solicitud a fallado: " +  textStatus, 4000); 
                   }
            });


        }else{


            Materialize.toast("debe completar los campos!", 4000);  
        }

       
   
    });  
      
     
    
});


function modificarTiempoRefresco(){

    setInterval(function(){ 
      
       // alert("Hello"); 
    
     }, $("#tiempoRefresco").val());

    tiempoDeRefresco =  $("#tiempoRefresco").val();

    return tiempoDeRefresco;

}


setInterval(function(){ 
      
    refrescarNoticias(); 
    
    Materialize.toast("Noticias Actualizadas", 2000);

 }, $("#tiempoRefresco").val());



 function refrescarNoticias(){

    $.ajax({
        // En data puedes utilizar un objeto JSON, un array o un query string
        data: {"action" : "refrescaNoticia"},
        //Cambiar a type: POST si necesario
        type: "GET",
        // Formato de datos que se espera en la respuesta
        dataType: "json",
        // URL a la que se enviará la solicitud Ajax
        url: url,
    })
     .done(function( data, textStatus, jqXHR ) {
        var tarjeta = "";       
       

        $.each(data, function(i, n){
           console.log("vaina: "+n.titulo)
           obtenerImagenPorNoticiaId(n.noticiaId,url);               
            
            tarjeta += 
            '<div class="contenedor_tarjetas">'
            +'<a href="'+url+"?action=noticiaparticular&id="+n.noticiaId+'">'
            +'      <h4 class="titulo cortarTextoTitulos">'+n.titulo+'</h4>'     
            +'  <figure>   '      
             +'   <img src="data:image/png;charset=utf8;base64, '+ localStorage.getItem("encodingImagen"+n.noticiaId)+'" class="frontal" />'
            +'      <figcaption class="trasera wordwrap">'
            +'        <h4 class="titulo cortarTextoTitulos">'+n.titulo+'</h4>'
            +'        <hr>'
            +'       <p class="cortarTextoNoticia">'+n.texto+'</p>'
           // +'        <hr>'
            //+'       <p class="">Comentarios: '+n.totalComentarios+'</p>'
            +'      </figcaption>'
            +'    </figure>'
            +'  </a>         '     
            +' </div>'
         
          
          // console.log( "La solicitud fue exitosa2: " +  localStorage.getItem("encodingImagen"));
          });
        
          $('#contenedor').html('');
          $("#contenedor").append(tarjeta);
          localStorage.clear();
        
     })
     .fail(function( jqXHR, textStatus, errorThrown ) {
         if ( console && console.log ) {
             console.log( "La solicitud a fallado 2: " +  textStatus);
         }
    });   
     
 }


function obtenerImagenPorNoticiaId(noticiaId,url) {    
   
    console.log("noticiaId: "+noticiaId)
   
    $.getJSON(url,{"action" : "obtenerimagen", "noticiaId": noticiaId}, function(data) {
          // localStorage.clear();
           // Store
           localStorage.setItem("encodingImagen"+noticiaId, data);
         
      });
      
     return false;
}

function ModificarNoticia(){

    var titulo = $('#titulo');
    var texto = $('#texto');
    var noticiaId = $('#noticiaId');

    if(titulo.text() != "" && texto.text() != "" && noticiaId.val() != ""){

        $.ajax({
            // En data puedes utilizar un objeto JSON, un array o un query string
            data: {"action" : "modificaNoticia", "titulo": titulo.text(), "texto": texto.text(),"noticiaId":noticiaId.val()},
            //Cambiar a type: POST si necesario
            type: "POST",
            // Formato de datos que se espera en la respuesta
           // dataType: "json",
            // URL a la que se enviará la solicitud Ajax
            url: "../Controladores/servidorNoticias.php",
        })
         .done(function(data, textStatus, jqXHR ) {
                          
         console.log(data)
          if(data == "true"){
  
            Materialize.toast("Noticia modificada correctamente", 4000);        

          }else{

            Materialize.toast("Hubo un Error no se pudo modificar la noticia", 4000);   
          }
            
         })
         .fail(function(jqXHR, textStatus, errorThrown ) {
             if (console && console.log ) {
                 console.log( "La solicitud a fallado: " +  textStatus);
             }
        });


    }else{

        Materialize.toast("Debe completar los campos!", 4000);   
        
    }
}

$(document).bind("ajaxStart.mine", function() {
    $('#ajaxProgress').show();
});

$(document).bind("ajaxStop.mine", function() {
    $('#ajaxProgress').hide();
});