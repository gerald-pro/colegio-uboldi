$(document).ready(function () {
    window.verReporte = function () {
        var idEstudiante = $('#idEstudiante').val();

        if (idEstudiante) {
            $.ajax({
                url: 'ajax/reportes.ajax.php',
                method: 'POST',
                data: { idEstudiante: idEstudiante },
                success: function (response) {
                    $('#contenidoReporte').html(response); // Colocar el contenido en el modal
                    $('#modalReporte').modal('show'); // Mostrar el modal
                },
                error: function () {
                    alert('Error al generar el reporte');
                }
            });
        } else {
            alert('Seleccione un estudiante para ver el reporte.');
        }
    };

    $(document).ready(function () {
        window.generarRepEstudiantesXApoderadoPDF = function () {
            var idApoderado = $('#idApoderado').val();

            if (idApoderado) {
                $.ajax({
                    url: 'ajax/reportes.ajax.php',
                    method: 'POST',
                    data: { idApoderadoReporte: idApoderado },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function (response) {
                        var blob = new Blob([response], { type: 'application/pdf' });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'estudiantes_por_apoderado.pdf';  // Nombre del archivo PDF
                        link.click();
                    },
                    error: function (xhr, status, error) {
                        console.error("Error al generar el PDF:", error);
                    }
                });
            } else {
                alert('Seleccione un apoderado para descargar el reporte.');
            }
        };
    });

    $('#formReporte').on('submit', function (e) {
        e.preventDefault();
        var idEstudiante = $('#idEstudiante').val();

        if (idEstudiante) {
            $.ajax({
                url: 'ajax/reportes.ajax.php',
                method: 'POST',
                data: { idEstudiante: idEstudiante },
                success: function (response) {
                    $('#resultadoReporte').html(response).show();

                    if (response.includes('table')) {
                        $('#botonGenerarPDF').show();
                    } else {
                        $('#botonGenerarPDF').hide();
                    }
                }
            });

        }
    });
});


function generarPDF() {
    var idEstudiante = $('#idEstudiante').val();

    if (idEstudiante) {
        $.ajax({
            url: 'ajax/reportes.ajax.php',
            method: 'POST',
            data: { idEstudianteReporte: idEstudiante },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'historial_pagos.pdf';
                link.click();
            },
            error: function (xhr, status, error) {
                console.error("Error al generar el PDF:", error);
            }
        });
    }
}

function generarCuotasPorApoderadoPDF() {
    var idApoderadoCuota = $('#idApoderadoCuota').val();

    if (idApoderadoCuota) {
        $.ajax({
            url: 'ajax/reportes.ajax.php',
            method: 'POST',
            data: { idApoderadoCuota: idApoderadoCuota },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'reporte_cuotas_apoderado.pdf';
                link.click();
            },
            error: function (xhr, status, error) {
                console.error("Error al generar el PDF:", error);
            }
        });
    } else {
        alert('Seleccione un apoderado para descargar el reporte.');
    }
}

function generarPagosPorPeriodoPDF() {
    var fechaInicio = $('#fechaInicio').val();
    var fechaFin = $('#fechaFin').val();

    if (fechaInicio && fechaFin) {
        $.ajax({
            url: 'ajax/reportes.ajax.php',
            method: 'POST',
            data: { fechaInicioPago: fechaInicio, fechaFinPago: fechaFin },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'reporte_pagos_periodo.pdf';
                link.click();
            },
            error: function (xhr, status, error) {
                console.error("Error al generar el PDF:", error);
            }
        });
    } else {
        alert('Seleccione ambas fechas para generar el reporte.');
    }
}

function generarEstudiantesPorFechaPDF() {
    var fechaInicioRegistro = $('#fechaInicioRegistro').val();
    var fechaFinRegistro = $('#fechaFinRegistro').val();

    if (fechaInicioRegistro && fechaFinRegistro) {
        $.ajax({
            url: 'ajax/reportes.ajax.php',
            method: 'POST',
            data: { fechaInicioRegistro: fechaInicioRegistro, fechaFinRegistro: fechaFinRegistro },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'reporte_estudiantes_registro.pdf';
                link.click();
            },
            error: function (xhr, status, error) {
                console.error("Error al generar el PDF:", error);
            }
        });
    } else {
        alert('Seleccione ambas fechas para generar el reporte.');
    }
}

function generarEstudiantesPorCursoPDF() {
    var idCurso = $('#idCurso').val();

    if (idCurso) {
        $.ajax({
            url: 'ajax/reportes.ajax.php',
            method: 'POST',
            data: { idCursoEstudiantes: idCurso },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'reporte_estudiantes_por_curso.pdf';
                link.click();
            },
            error: function (xhr, status, error) {
                console.error("Error al generar el PDF:", error);
            }
        });
    } else {
        alert('Seleccione un curso para generar el reporte.');
    }
}

function generarEstudiantesCuotasPendientesPDF() {
    $.ajax({
        url: 'ajax/reportes.ajax.php',
        method: 'POST',
        data: { estudiantesCuotasPendientes: true },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response) {
            var blob = new Blob([response], { type: 'application/pdf' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'reporte_estudiantes_cuotas_pendientes.pdf';
            link.click();
        },
        error: function (xhr, status, error) {
            console.error("Error al generar el PDF:", error);
        }
    });
}

function generarCursosConMasEstudiantesPDF() {
    $.ajax({
        url: 'ajax/reportes.ajax.php',
        method: 'POST',
        data: { cursosMasEstudiantes: true },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response) {
            var blob = new Blob([response], { type: 'application/pdf' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'reporte_cursos_mas_estudiantes.pdf';
            link.click();
        },
        error: function (xhr, status, error) {
            console.error("Error al generar el PDF:", error);
        }
    });
}

function generarPagosPorApoderadoPDF() {
    var idApoderado = $('#idPagosPorApoderado').val();

    if (idApoderado) {
        $.ajax({
            url: 'ajax/reportes.ajax.php',
            method: 'POST',
            data: { pagosPorApoderado: idApoderado },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'reporte_pagos_apoderado.pdf';
                link.click();
            },
            error: function (xhr, status, error) {
                console.error("Error al generar el PDF:", error);
            }
        });
    } else {
        alert("Seleccione un apoderado para generar el reporte.");
    }
}

function generarEstudiantesMayorPagoPDF() {
    $.ajax({
        url: 'ajax/reportes.ajax.php',
        method: 'POST',
        data: { estudiantesMayorPago: true },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response) {
            var blob = new Blob([response], { type: 'application/pdf' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'reporte_estudiantes_mayor_pago.pdf';
            link.click();
        },
        error: function (xhr, status, error) {
            console.error("Error al generar el PDF:", error);
        }
    });
}