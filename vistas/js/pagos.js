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
            $("#verIdApoderado").val(respuesta.id_apoderado);
            $("#verCurso").val(respuesta.curso.nombre + respuesta.curso.paralelo);
            $("#detalleMetodo").val(respuesta["id_metodo_pago"]);
            $("#verGestion").val(respuesta["gestion"]);
            $("#verCuota").val(respuesta["cuota"]);
            $("#verMonto").val(respuesta["monto_total"]);
            $("#detalleMonto").val(respuesta["monto_total"]);

            $("#detalleCuotas").html("");

            var detalleCuotasHTML = `
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Gestión</th>
                            <th>Mes</th>
                            <th>Monto (Bs)</th>
                        </tr>
                    </thead>
                    <tbody>`;


            // Asignar detalles de las cuotas pagadas
            if (respuesta.detalle_cuotas) {
                respuesta.detalle_cuotas.forEach(function (detalle) {
                    detalleCuotasHTML += `
                        <tr>
                            <td>${detalle.gestion}</td>
                            <td>${detalle.mes}</td>
                            <td>${detalle.monto}</td>
                        </tr>`;
                });
            } else {
                detalleCuotasHTML += `
                    <tr>
                        <td colspan="3">No hay cuotas asociadas</td>
                    </tr>`;
            }

            detalleCuotasHTML += `
                    </tbody>
                </table>`;

            $("#detalleCuotas").html(detalleCuotasHTML);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
            console.error("Respuesta del servidor: ", jqXHR.responseText);
        }
    });
});

function actualizarMontoTotal() {
    var totalMonto = 0;
    $("#nuevoIdCuotas option:selected").each(function () {
        var monto = $(this).data("monto");
        totalMonto += parseFloat(monto);
    });
    $("#nuevoMonto").val(totalMonto.toFixed(2));
}


$(document).ready(function () {
    $("#nuevoIdEstudiante").change(function () {
        var idEstudiante = $(this).val();

        $("#nuevoIdCuota").html('<option value="">Seleccionar cuota pendiente</option>');
        $("#nuevoIdCuotas").html('');
        actualizarMontoTotal();

        if (idEstudiante) {
            var datos = new FormData();
            datos.append("idEstudiante", idEstudiante);

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

                    // Llenar el select con las cuotas pendientes
                    if (respuesta.length > 0) {
                        respuesta.forEach(function (cuota) {
                            $("#nuevoIdCuotas").append('<option value="' + cuota.id + '" data-monto="' + cuota.monto + '" data-curso="' + cuota.id_curso + '">Mes: ' + cuota.mes + ' - Monto: ' + cuota.monto + '</option>');
                        });
                    } else {
                        $("#nuevoIdCuotas").html('<option value="">No hay cuotas pendientes</option>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
                }
            });

            $.ajax({
                url: "ajax/apoderado.ajax.php",
                method: "POST",
                data: { idEstudiante: idEstudiante },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta) {
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
                        $("#nuevoIdCurso").val(respuesta.nombre); // Aquí asumimos que respuesta tiene el nombre del curso
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("Error al obtener el curso: ", textStatus, errorThrown);
                }
            });
        }
    });

    $("#nuevoIdCuotas").change(function () {
        actualizarMontoTotal();
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
