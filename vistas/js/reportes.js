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