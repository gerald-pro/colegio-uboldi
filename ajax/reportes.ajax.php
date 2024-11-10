<?php

require_once "../controladores/ReporteControlador.php";
require_once "../modelos/Pago.php";
require_once "../modelos/Estudiante.php";
require_once "../modelos/Apoderado.php";
require_once "../modelos/Usuario.php";

if (isset($_POST["idEstudiante"]) && isset($_POST["historialPagos"])) {
    $reporte = ReporteControlador::historialPagosEstudiante($_POST["idEstudiante"]);

    if ($reporte) {
        $estudiante = $reporte['estudiante'];
        $pagos = $reporte['pagos'];

        echo "<h5>Estudiante: {$estudiante['nombre']} {$estudiante['apellidos']}</h5>";
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>
        <tr>
        <th>Código</th><th>Fecha</th><th>Apoderado</th><th>Usuario</th><th>Monto (Bs)</th>
        </tr>
        </thead>";
        echo "<tbody>";
        foreach ($pagos as $pago) {

            $apoderado = Apoderado::buscarPorId($pago['id_apoderado']);
            $usuario = Usuario::buscarPorId($pago['id_usuario']);
            $fecha = date_create($pago["fecha"]);
            $fechaFormateada = date_format($fecha, "d/m/y H:i");

            echo "<tr>";
            echo "<td>{$pago['codigo']}</td>";
            echo "<td>{$fechaFormateada}</td>";
            echo "<td>{$apoderado['nombre']}</td>";
            echo "<td>{$usuario['usuario']}</td>";
            echo "<td>{$pago['monto_total']}</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "No se encontraron pagos para este estudiante.";
    }
}

if (isset($_POST["idApoderadoReporte"])) {
    $pdfContent = ReporteControlador::estudiantesPorApoderadoPDF($_POST["idApoderadoReporte"]);
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}

if (isset($_POST["idEstudianteReporte"])) {
    $pdfContent = ReporteControlador::historialPagosEstudiantePDF($_POST["idEstudianteReporte"]);
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}

if (isset($_POST["idApoderadoCuota"])) {
    $pdfContent = ReporteControlador::cuotasPorApoderadoPDF($_POST["idApoderadoCuota"]);
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}

if (isset($_POST["fechaInicioPago"]) && isset($_POST["fechaFinPago"])) {
    $fechaInicio = $_POST["fechaInicioPago"];
    $fechaFin = $_POST["fechaFinPago"];

    $pdfContent = ReporteControlador::pagosPorPeriodoPDF($fechaInicio, $fechaFin);
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}

if (isset($_POST["fechaInicioRegistro"]) && isset($_POST["fechaFinRegistro"])) {
    $fechaInicio = $_POST["fechaInicioRegistro"];
    $fechaFin = $_POST["fechaFinRegistro"];

    $pdfContent = ReporteControlador::estudiantesPorFechaRegistroPDF($fechaInicio, $fechaFin);
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}

if (isset($_POST["idCursoEstudiantes"])) {
    $idCurso = $_POST["idCursoEstudiantes"];

    $pdfContent = ReporteControlador::estudiantesPorCursoPDF($idCurso);
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}

if (isset($_POST["estudiantesCuotasPendientes"])) {
    $pdfContent = ReporteControlador::estudiantesCuotasNoPagadasPDF();
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}

if (isset($_POST["estudiantesDeudoresCurso"])) {
    
    $pdfContent = ReporteControlador::estudiantesDeudoresPorCursoPDF($_POST["estudiantesDeudoresCurso"]);
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}

if (isset($_POST["cursosMasEstudiantes"])) {
    $pdfContent = ReporteControlador::cursosConMasEstudiantesPDF();
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}

if (isset($_POST["pagosPorApoderado"])) {
    $idApoderado = $_POST["pagosPorApoderado"];
    $pdfContent = ReporteControlador::pagosPorApoderadoPDF($idApoderado);
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}

if (isset($_POST["estudiantesMayorPago"])) {
    $pdfContent = ReporteControlador::estudiantesMayorPagoPDF();
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}

if (isset($_POST["idEstudiante"]) && isset($_POST["cuotasPendientes"])) {
    $pdfContent = ReporteControlador::cuotasPendientesDetalladoPorEstudiantePDF($_POST["idEstudiante"]);
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}

if (isset($_POST["fechaInicio"]) && isset($_POST["fechaFin"]) && isset($_POST["cuotasPendientes"])) {
    $pdfContent = ReporteControlador::cuotasPendientesPorPeriodoPDF($_POST["fechaInicio"], $_POST["fechaFin"]);
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}
