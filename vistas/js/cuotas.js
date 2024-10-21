$(document).ready(function () {
    $("#nuevoIdEstudianteCuota, #editarIdEstudianteCuota").change(function () {
        var idApoderado = $(this).find("option:selected").data("apoderado");
        $(this).closest("form").find("select[name='nuevoIdApoderadoCuota'], select[name='editarIdApoderadoCuota']").val(idApoderado);
    });
});

// Editar cuota
$(".tablas").on("click", ".btnEditarCuota", function () {
    var id = $(this).attr("id");
    var datos = new FormData();
    datos.append("id", id);

    $.ajax({
        url: "ajax/cuotas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta);
            $("#editarFechaVencimiento").val(respuesta["fecha_vencimiento"]);
            $("#editarMonto").val(respuesta["monto"]);
            $("#editarGestion").val(respuesta["gestion"]);
            $("#editarMes").val(respuesta["mes"]);
            $("#editarId").val(respuesta["id"]);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
            console.error("Respuesta del servidor: ", jqXHR.responseText);
        }
    });
});

// Eliminar cuota
$(".tablas").on("click", ".btnEliminarCuota", function () {
    var id = $(this).attr("id");
    swal({
        title: '¿Está seguro de borrar la cuota?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, borrar cuota!'
    }).then(function (result) {
        if (result.value) {
            window.location = "index.php?rutas=cuotas&id=" + id;
        }
    });
});