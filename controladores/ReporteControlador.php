<?php

require_once('../extensiones/tcpdf/tcpdf.php');
require_once("../modelos/Curso.php");
require_once("../modelos/Usuario.php");
require_once("../modelos/Apoderado.php");

class ReporteControlador
{
    static public function historialPagosEstudiante($idEstudiante = null)
    {
        if ($idEstudiante !== null) {
            $pagos = Pago::listarPorEstudiante($idEstudiante);
            $estudiante = Estudiante::listar('id', $idEstudiante);
            return [
                'estudiante' => $estudiante,
                'pagos' => $pagos
            ];
        } else {
            return null;
        }
    }

    static public function historialPagosEstudiantePDF($idEstudiante)
    {
        $datos = self::historialPagosEstudiante($idEstudiante);
        if ($datos) {
            $pdf = new TCPDF();
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage();

            $pdf->SetFont('helvetica', '', 11);
            $pdf->MultiCell(
                80,
                16,
                "Colegio M. Uboldi\n" .
                    "NIT: 14495733\n" .
                    "Dirección: Santa Cruz de la Sierra",
                0,
                "L",
                false,
                1,
            );

            $pdf->MultiCell(
                80,
                16,
                "Fecha: " . date("Y/m/d") . "\n" .
                    "ubaldo.colegio@gmail.com",
                0,
                "L",
                false,
                1,
                100,
                10
            );

            $pdf->SetFont('helvetica', 'B', 15);

            // Título del reporte
            $pdf->Cell(0, 18, 'HISTORIAL DE PAGOS', 0, 1, 'C');

            $pdf->SetFont('helvetica', '', 12);
            // Información del estudiante
            $pdf->Cell(0, 6, 'Estudiante: ' . $datos['estudiante']['nombre'] . ' ' . $datos['estudiante']['apellidos'], 0, 1);
            $pdf->Cell(0, 6, 'Correo: ' . $datos['estudiante']['correo'], 0, 1);
            $pdf->Cell(0, 6, 'Telf: ' . $datos['estudiante']['telefono'], 0, 1);

            $pdf->SetY(72);
            $pdf->SetFont('helvetica', '', 11);
            // Tabla de pagos
            $pdf->Cell(24, 8, 'Código', 1, '', "C");
            $pdf->Cell(33, 8, 'Fecha', 1, '', "C");
            $pdf->Cell(40, 8, 'Apoderado', 1, '', "C");
            $pdf->Cell(40, 8, 'Usuario', 1, '', "C");
            $pdf->Cell(18, 8, 'Gestión', 1, '', "C");
            $pdf->Cell(15, 8, 'Curso', 1, '', "C");
            $pdf->Cell(21, 8, 'Monto (bs)', 1, '', "C");    
            $pdf->Ln();


            foreach ($datos['pagos'] as $pago) {
                try {
                    $idCurso = $pago['id_curso'];

                    $apoderado = Apoderado::buscarPorId($pago['id_apoderado']);
                    $usuario = Usuario::buscarPorId($pago['id_usuario']);
                    $curso = Curso::buscarPorId($idCurso);

                    $fecha = date_create($pago["fecha"]);
                    $fechaFormateada = date_format($fecha, "d/m/y H:i");

                    $pdf->Cell(24, 8, $pago['codigo'], 1);
                    $pdf->Cell(33, 8, $fechaFormateada, 1);
                    $pdf->Cell(40, 8, $apoderado['nombre'] . " " . $apoderado['apellido'], 1, '', 'L');
                    $pdf->Cell(40, 8, $usuario['usuario'], 1, '', 'L');
                    $pdf->Cell(18, 8, $pago['gestion'], 1, '', 'R');
                    $pdf->Cell(15, 8, $curso['curso'] . " " . $curso['paralelo'], 1, '', 'R');
                    $pdf->Cell(21, 8, $pago['monto'], 1, '', 'R');
                    $pdf->Ln();
                } catch (\Throwable $th) {
                    $message = $th;
                }
            }

            return $pdf->Output('', 'S');
        } else {
            echo 'No se encontraron datos para el estudiante seleccionado.';
        }
    }
}
