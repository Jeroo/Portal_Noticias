$(document).ready(function() {
    
  $('#listaLibros').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
        /*,
        "sDom": '<"bottom"flp>rt<"top"i><"clear">'*/
    },
    );
    
    $('select').material_select();
    
    $('select').on('change', function() {
        
        var id = this.id;
        
        if (id == "stlformato") {
            
            $('#formato').val(this.value);
            
        }else if (id == "stlcategoria") {
            
             $('#categoria').val(this.value);
        }
        
     });
     
     
     $('#btnGuardar').click(function(){
         //alert($('#recomendado').val())
         var checkbox = document.getElementById('chkrecomendado');        
        
          if (checkbox.checked) {
             
             $('#recomendado').val(1);
             
           }else {
            
             $('#recomendado').val(0);
          }

         $('form#formAgregar').submit();
    
     });    
     
    
     
    
} );