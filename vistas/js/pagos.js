/*=============================================
MOSTRAR PAGO
=============================================*/

$(".tablas").on("click", ".btnVerPago", function () {
    var id = $(this).attr("id");

    var datos = new FormData();
    datos.append("id", id);

    $.ajax({
        url: "ajax/pagos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta)
            $("#verCpago").val(respuesta["codigo"]);
            $("#verFecha").val(respuesta["fecha"]);
            $("#verHora").val(respuesta["hora"]);
            $("#verMonto").val(respuesta["monto"]);

            $("#verIdEstudiante").val(respuesta["id_estudiante"]);
            $("#verIdApoderado").val(respuesta["id_apoderado"]);
            $("#verIdCurso").val(respuesta["id_curso"]);

            $("#detalleMetodo").val(respuesta["id_metodo_pago"]);
            $("#detalleGestion").val(respuesta["gestion"]);
            $("#detalleMonto").val(respuesta["monto"]);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
            console.error("Respuesta del servidor: ", jqXHR.responseText);
        }
    });
});

$(document).ready(function () {
    $("#nuevoIdEstudiante").change(function () {
        var idApoderado = $(this).find("option:selected").data("apoderado");
        $("#nuevoIdApoderado").val(idApoderado);
    });
});

/*=============================================
EDITAR PAGO
=============================================*/
$(".tablas").on("click", ".btnEditarPago", function () {
    var id = $(this).attr("id");
    var datos = new FormData();
    datos.append("id", id);

    $.ajax({
        url: "ajax/pagos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta);
            
            $("#editarCodigo").val(respuesta["codigo"]);
            $("#editarFecha").val(respuesta["fecha"]);
            $("#editarHora").val(respuesta["hora"]);
            $("#editarMonto").val(respuesta["monto"]);

            $("#editarIdEstudiante").val(respuesta["id_estudiante"]);
            $("#editarIdApoderado").val(respuesta["id_apoderado"]);
            $("#editarIdCurso").val(respuesta["id_curso"]);

            $("#editarIdUsuario").val(respuesta["id_usuario"]);
            $("#idPago").val(respuesta["id"]);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
            console.error("Respuesta del servidor: ", jqXHR.responseText);
        }
    });
});

/*=============================================
ELIMINAR PAGO
=============================================*/
$(".tablas").on("click", ".btnEliminarPago", function () {
    var id = $(this).attr("id");
    swal({
        title: '¿Está seguro de borrar el pago?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar pago!'
    }).then(function (result) {
        if (result.value) {
            window.location = "index.php?rutas=pagos&id=" + id;
        }
    });
});
