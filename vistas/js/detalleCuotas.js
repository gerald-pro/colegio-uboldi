/*=============================================
EDITAR DETALLE DE CUOTA
=============================================*/
$(".tablas").on("click", ".btnEditarDetalleCuotas", function(){
    var id = $(this).attr("id");
    var datos = new FormData();
    datos.append("id", id);
    console.log("hola");
    $.ajax({
        url: "ajax/detalleCuotas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            $("#editarCodigo").val(respuesta["codigo"]);
            $("#editarGestion").val(respuesta["gestion"]);
            $("#editarMonto").val(respuesta["monto"]);
            $("#editarNcuotas").val(respuesta["n_cuotas"]);
            $("#idDetalleCuota").val(respuesta["id"]);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
            console.error("Respuesta del servidor: ", jqXHR.responseText);
        }
    });
});

/*=============================================
ELIMINAR DETALLE DE CUOTA
=============================================*/
$(".tablas").on("click", ".btnEliminarDetalleCuotas", function(){
     var id = $(this).attr("id");
     swal({
         title: '¿Está seguro de borrar el detalle de cuotas?',
         text: "¡Si no lo está puede cancelar la acción!",
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#007bff',
         cancelButtonColor: '#d33',
         cancelButtonText: 'Cancelar',
         confirmButtonText: 'Si, borrar detalle de cuotas!'
     }).then(function(result){
         if(result.value){
             window.location = "index.php?rutas=detalleCuotas&id=" + id;
         }
     });
});
