/*=============================================
EDITAR CURSO
=============================================*/
$(".tablas").on("click", ".btnEditarCurso", function(){

	var id = $(this).attr("idCurso");

	var datos = new FormData();
	datos.append("id", id);

	$.ajax({
		url: "ajax/cursos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json",
		success: function(respuesta){
			$("#editarCurso").val(respuesta["curso"]);
			$("#editarParalelo").val(respuesta["paralelo"]);
			$("#idCurso").val(respuesta["id"]);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
			console.error("Respuesta del servidor: ", jqXHR.responseText);
		}
	})

})

/*=============================================
ELIMINAR CURSO
=============================================*/
$(".tablas").on("click", ".btnEliminarCurso", function(){

	var id = $(this).attr("idCurso");

	swal({
		title: '¿Está seguro de borrar el curso?',
		text: "¡Si no lo está puede cancelar la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, borrar curso!'
	}).then(function(result){
		if (result.value) {
			window.location = "index.php?rutas=cursos&id=" + id;
		}

	})

})