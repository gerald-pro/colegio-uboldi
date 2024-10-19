$(document).ready(function () {
    $('#formReporte').on('submit', function (e) {
        e.preventDefault();
        var idEstudiante = $('#idEstudiante').val();
        $.ajax({
            url: 'ajax/historialPagos.ajax.php',
            method: 'POST',
            data: { idEstudiante: idEstudiante },
            success: function (response) {
                $('#resultadoReporte').html(response).show();
            }
        });
    });
});


function generarPDF() {
    var idEstudiante = $('#idEstudiante').val();

    $.ajax({
        url: 'ajax/historialPagos.ajax.php',
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