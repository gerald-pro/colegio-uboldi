/*=============================================
EDITAR APODERADO
=============================================*/
$(".tablas").on("click", ".btnEditarApoderado", function(){
    var id = $(this).attr("id");
    var datos = new FormData();
    datos.append("id", id);

    $.ajax({
        url: "ajax/apoderado.ajax.php",
        method: "POST",
          data: datos,
          cache: false,
         contentType: false,
         processData: false,
         dataType:"json",
         success: function(respuesta){
             $("#EditarNombre").val(respuesta["nombre"]);
             $("#EditarApellido").val(respuesta["apellido"]);
             $("#EditarTelefono").val(respuesta["telefono"]);
             $("#EditarDireccion").val(respuesta["direccion"]);
             $("#EditarIdUsuario").val(respuesta["id_usuario"]);
             $("#IdApoderado").val(respuesta["id"]);
         },
         error: function (jqXHR, textStatus, errorThrown) {
			console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
			console.error("Respuesta del servidor: ", jqXHR.responseText);
		}

    })


})

/*=============================================
ELIMINAR APODERADO
=============================================*/
$(".tablas").on("click", ".btnEliminarApoderado", function(){
     var id = $(this).attr("id");
     swal({
         title: '¿Está seguro de borrar el apoderado?',
         text: "¡Si no lo está puede cancelar la acción!",
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#007bff',
         cancelButtonColor: '#d33',
         cancelButtonText: 'Cancelar',
         confirmButtonText: 'Si, borrar apoderado!'
     }).then(function(result){
         if(result.value){
             window.location = "index.php?rutas=apoderados&id=" + id;
         }
     })

})