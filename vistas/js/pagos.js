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
            $("#verCodigo").val(respuesta["codigo"]);
            $("#verFecha").val(respuesta["fecha"]);
            $("#verHora").val(respuesta["hora"]);
            $("#verMonto").val(respuesta["monto"]);
            $("#verIdEstudiante").val(respuesta["id_estudiante"]);
            $("#verIdApoderado").val(respuesta["id_apoderado"]);
            $("#verIdCurso").val(respuesta["id_curso"]);
            $("#detalleMetodo").val(respuesta["id_metodo_pago"]);
            $("#verGestion").val(respuesta["gestion"]);
            $("#verCuota").val(respuesta["cuota"]);
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
        var idEstudiante = $(this).val();

        $("#nuevoIdCuota").html('<option value="">Seleccionar cuota pendiente</option>');

        if (idEstudiante) {
            var datos = new FormData();
            datos.append("idEstudiante", idEstudiante);

            $.ajax({
                url: "ajax/cuotas.ajax.php", // Endpoint que se encargará de devolver las cuotas pendientes
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (respuesta) {
                    // Llenar el select con las cuotas pendientes
                    if (respuesta.length > 0) {
                        respuesta.forEach(function (cuota) {
                            $("#nuevoIdCuota").append('<option value="' + cuota.id + '" data-monto="' + cuota.monto + '" data-curso="' + cuota.id_curso + '">Mes: ' + cuota.mes + ' - Monto: ' + cuota.monto + '</option>');
                        });
                    } else {
                        $("#nuevoIdCuota").html('<option value="">No hay cuotas pendientes</option>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
                }
            });

            $.ajax({
                url: "ajax/apoderado.ajax.php", // Endpoint que devolverá el apoderado correspondiente
                method: "POST",
                data: { idEstudiante: idEstudiante },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta) {
                        // Asigna el nombre del apoderado al input
                        $("#nuevoIdApoderado").val(respuesta.nombre + ' ' + respuesta.apellido);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("Error al obtener el apoderado: ", textStatus, errorThrown);
                }
            });

            $.ajax({
                url: "ajax/cursos.ajax.php", // Endpoint para obtener el curso
                method: "POST",
                data: { idEstudiante: idEstudiante },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta) {
                        // Asigna el nombre del curso al input
                        $("#nuevoIdCurso").val(respuesta.nombre); // Aquí asumimos que respuesta tiene el nombre del curso
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("Error al obtener el curso: ", textStatus, errorThrown);
                }
            });
        }
    });

    $("#nuevoIdCuota").change(function () {
        var monto = $(this).find("option:selected").data("monto");
        var idCurso = $(this).find("option:selected").data("curso");
        $("#nuevoMonto").val(monto);
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
