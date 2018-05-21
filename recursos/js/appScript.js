$(document).ready(function() {
    $('.modal').modal();
    $('.carousel').carousel();
    $('.collapsible').collapsible();
    /**
     * 
     * Inicializar noticias
     */
    var url = "./Controladores/servidorNoticias.php";
     
  

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
            +'      </figcaption>'
            +'    </figure>'
            +'  </a>         '     
            +' </div>'
         
          
          // console.log( "La solicitud fue exitosa2: " +  localStorage.getItem("encodingImagen"));
          });
        
          $("#contenedor").append(tarjeta);
          localStorage.clear();
        
     })
     .fail(function( jqXHR, textStatus, errorThrown ) {
         if ( console && console.log ) {
             console.log( "La solicitud a fallado 2: " +  textStatus);
         }
    });
    
  /*$('#listaLibros').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
        /*,
        "sDom": '<"bottom"flp>rt<"top"i><"clear">'
    },
);*/
    
    $('select').material_select();
    
    $('select').on('change', function() {
        
        var id = this.id;
        
        if (id == "stlformato") {
            
            $('#formato').val(this.value);
            
        }else if (id == "stlcategoria") {
            
             $('#categoria').val(this.value);
        }
        
     });
     
     
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

                alert("Hubo un error al agregar la noticia. favor contacte al administracion del sistema");
              }
                
             })
             .fail(function(jqXHR, textStatus, errorThrown ) {
                 if (console && console.log ) {
                     console.log( "La solicitud a fallado: " +  textStatus);
                 }
            });


        }else{


            alert("debe completar los campos antes de guardar!");
        }

       
   
    });  

    $('#bntLimpiarGuardarNoticia').click(function(e){

        titulo = $('#titulo');
        texto = $('#texto');

        titulo.val('');
        texto.val('');
        $('#imagenesDiv').addClass("hide");
        
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


    $('#btnAgregarEditarNoticia').click(function(e){

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

                alert("Noticia modificada correctamente");               

              }else{

                alert("Hubo un Error no se pudo modificar la noticia");
              }
                
             })
             .fail(function(jqXHR, textStatus, errorThrown ) {
                 if (console && console.log ) {
                     console.log( "La solicitud a fallado: " +  textStatus);
                 }
            });


        }else{


            alert("Debe completar los campos!");
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

                alert("Usuario Autenticado");
                window.location ='../index.php';

              }else{

                alert("Usuario o clave incorrecto");
              }
                
             })
             .fail(function(jqXHR, textStatus, errorThrown ) {
                 if (console && console.log ) {
                     console.log( "La solicitud a fallado: " +  textStatus);
                 }
            });


        }else{


            alert("debe completar los campos!");
        }

       
   
    });  
    


         
     // Variable to hold request
var request;

// Bind to the submit event of our form
$("#").submit(function(event){

    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    // Abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = $(this);

    // Let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");

    // Serialize the data in the form
    var serializedData = $form.serialize();

    // Let's disable the inputs for the duration of the Ajax request.
    // Note: we disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);

    // Fire off the request to /form.php
    request = $.ajax({
        url: "../Controladores/servidorNoticias.php",
        type: "post",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Hooray, it worked!");
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });

});    
    
     
    
} );


function obtenerImagenPorNoticiaId(noticiaId,url) {    
   
    console.log("noticiaId: "+noticiaId)
   
    $.getJSON(url,{"action" : "obtenerimagen", "noticiaId": noticiaId}, function(data) {
          // localStorage.clear();
           // Store
           localStorage.setItem("encodingImagen"+noticiaId, data);
         
      });
      
     return false;
}