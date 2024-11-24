<?php

require_once('../extensiones/tcpdf/tcpdf.php');
require_once("../modelos/Curso.php");
require_once("../modelos/Cuota.php");
require_once("../modelos/Usuario.php");
require_once("../modelos/Apoderado.php");

class ReporteControlador
{
    private static function configurarCabeceraPDF($pdf, $titulo)
    {
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 11);

        // Logo
        $logoPath = '../vistas/assets/images/colegio-uboldi.jpg';
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 10, 7, 23, 27, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        } else {
            error_log('El archivo de logo no se encuentra en la ruta especificada: ' . $logoPath);
        }

        // Información del colegio
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
            40
        );

        // Fecha de emisión
        $pdf->MultiCell(
            80,
            16,
            "Fecha de emisión: " . date("Y/m/d") . "\n" .
                "ubaldo.colegio@gmail.com",
            0,
            "L",
            false,
            1,
            120,
            6
        );

        // Título
        $pdf->SetFont('helvetica', 'B', 15);
        $pdf->SetY(30);
        $pdf->Cell(0, 18, $titulo, 0, 1, 'C');
    }

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

        $pdf = new TCPDF();
        self::configurarCabeceraPDF($pdf, 'HISTORIAL DE PAGOS');
        $pdf->SetFont('helvetica', '', 12);

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
        /* $pdf->Cell(18, 8, 'Gestión', 1, '', "C"); */
        $pdf->Cell(15, 8, 'Curso', 1, '', "C");
        $pdf->Cell(30, 8, 'Monto total (bs)', 1, '', "C");
        $pdf->Ln();

        if ($datos['pagos']) {
            foreach ($datos['pagos'] as $pago) {
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
                /* $pdf->Cell(18, 8, $cuota['gestion'], 1, '', 'R'); */
                $pdf->Cell(15, 8, $curso['nombre'] . " " . $curso['paralelo'], 1, '', 'R');
                $pdf->Cell(30, 8, $pago['monto_total'], 1, '', 'R');
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(182, 8, 'No se encontraron pagos registrados', 1, 0, "C");
        }

        return $pdf->Output('', 'S');
    }

    static public function estudiantesPorApoderadoPDF($idApoderado)
    {
        $apoderado = Apoderado::buscarPorId($idApoderado);
        $estudiantes = Estudiante::listarPorApoderado($idApoderado);

        $pdf = new TCPDF();
        self::configurarCabeceraPDF($pdf, 'REPORTE DE ESTUDIANTES POR APODERADO');

        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 6, 'Apoderado: ' . $apoderado['nombre'] . ' ' . $apoderado['apellido'], 0, 1);
        $pdf->Cell(0, 6, 'Dirección: ' . $apoderado['direccion'], 0, 1);
        $pdf->Cell(0, 6, 'Telf: ' . $apoderado['telefono'], 0, 1);

        $pdf->SetY(72);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(50, 8, 'Estudiante', 1, '', "C");
        $pdf->Cell(25, 8, 'Curso', 1, '', "C");
        $pdf->Cell(35, 8, 'Fecha nacimiento', 1, '', "C");
        $pdf->Cell(65, 8, 'Correo', 1, '', "C");
        $pdf->Ln();

        if ($estudiantes) {
            foreach ($estudiantes as $estudiante) {
                $curso = Curso::buscarPorId($estudiante['id_curso']);
                $pdf->Cell(50, 8, $estudiante['nombre'] . ' ' . $estudiante['apellidos'], 1);
                $pdf->Cell(25, 8, $curso['nombre'] . ' ' . $curso['paralelo'], 1);
                $pdf->Cell(35, 8, $estudiante['fecha_nacimiento'], 1);
                $pdf->Cell(65, 8, $estudiante['correo'], 1);
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(175, 8, 'No se encontraron estudiantes para este apoderado', 1, 0, "C");
        }

        return $pdf->Output('', 'S');
    }

    static public function cuotasPorApoderadoPDF($idApoderado)
    {
        $apoderado = Apoderado::buscarPorId($idApoderado);
        $cuotas = Cuota::listarPorApoderado($idApoderado); // Método en el modelo Cuota

        $pdf = new TCPDF();
        self::configurarCabeceraPDF($pdf, 'REPORTE DE CUOTAS POR APODERADO');

        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 6, 'Apoderado: ' . $apoderado['nombre'] . ' ' . $apoderado['apellido'], 0, 1);
        $pdf->Cell(0, 6, 'Dirección: ' . $apoderado['direccion'], 0, 1);
        $pdf->Cell(0, 6, 'Telf: ' . $apoderado['telefono'], 0, 1);

        $pdf->SetY(72);
        $pdf->SetFont('helvetica', '', 11);

        $pdf->Cell(20, 8, 'Gestión', 1, '', "C");
        $pdf->Cell(15, 8, 'Curso', 1, '', "C");
        $pdf->Cell(30, 8, 'Mes', 1, '', "C");
        $pdf->Cell(30, 8, 'Vencimiento', 1, '', "C");
        $pdf->Cell(50, 8, 'Estudiante', 1, '', "C");
        $pdf->Cell(25, 8, 'Monto (Bs)', 1, '', "C");
        $pdf->Ln();


        if ($cuotas) {
            foreach ($cuotas as $cuota) {
                $mes = 'No identificado';
                switch ($cuota["mes"]) {
                    case 1:
                        $mes = "enero";
                        break;
                    case 2:
                        $mes = "febrero";
                        break;
                    case 3:
                        $mes = "marzo";
                        break;
                    case 4:
                        $mes = "abril";
                        break;
                    case 5:
                        $mes = "mayo";
                        break;
                    case 6:
                        $mes = "junio";
                        break;
                    case 7:
                        $mes = "julio";
                        break;
                    case 8:
                        $mes = "agosto";
                        break;
                    case 9:
                        $mes = "septiembre";
                        break;
                    case 10:
                        $mes = "octubre";
                        break;
                    case 11:
                        $mes = "noviembre";
                        break;
                    case 12:
                        $mes = "diciembre";
                        break;
                }

                $pdf->Cell(20, 8, $cuota['gestion'], 1);
                $pdf->Cell(15, 8, $cuota['curso'], 1);
                $pdf->Cell(30, 8, $mes, 1);
                $pdf->Cell(30, 8, date("d/m/Y", strtotime($cuota['fecha_vencimiento'])), 1);
                $pdf->Cell(50, 8, $cuota['estudiante'], 1);
                $pdf->Cell(25, 8, $cuota['monto'], 1);
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(175, 8, 'No se encontraron cuotas registradas', 0, 0, "C");
        }

        return $pdf->Output('', 'S');
    }

    static public function pagosPorPeriodoPDF($fechaInicio, $fechaFin)
    {
        $pagos = Pago::listarPorPeriodo($fechaInicio, $fechaFin); // Método en el modelo Pago

        $pdf = new TCPDF();
        self::configurarCabeceraPDF($pdf, 'REPORTE DE PAGOS POR PERÍODO');

        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 6, 'Período: ' . date("d/m/Y", strtotime($fechaInicio)) . ' - ' . date("d/m/Y", strtotime($fechaFin)), 0, 1);

        $pdf->SetY(60);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(20, 8, 'Código', 1, '', "C");
        $pdf->Cell(40, 8, 'Fecha', 1, '', "C");
        $pdf->Cell(50, 8, 'Estudiante', 1, '', "C");
        $pdf->Cell(50, 8, 'Apoderado', 1, '', "C");
        $pdf->Cell(25, 8, 'Monto (Bs)', 1, '', "C");
        $pdf->Ln();

        $total = 0;

        if ($pagos) {
            foreach ($pagos as $pago) {
                $fechaPago = date("d/m/Y H:i", strtotime($pago['fecha']));
                $estudiante = Estudiante::listar('id', $pago['id_estudiante']);
                $apoderado = Apoderado::buscarPorId($pago['id_apoderado']);

                $pdf->Cell(20, 8, $pago['codigo'], 1);
                $pdf->Cell(40, 8, $fechaPago, 1);
                $pdf->Cell(50, 8, $estudiante['nombre'] . ' ' . $estudiante['apellidos'], 1);
                $pdf->Cell(50, 8, $apoderado['nombre'] . ' ' . $apoderado['apellido'], 1);
                $pdf->Cell(25, 8, $pago['monto_total'], 1, '', 'R');
                $pdf->Ln();

                $total += $pago['monto_total'];
            }

            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Cell(160, 8, 'Total', 1, '', 'R');
            $pdf->Cell(25, 8, $total, 1, '', 'R');
            $pdf->Ln();
        } else {
            $pdf->Cell(175, 8, 'No se encontraron estudiantes para este apoderado', 0, 0, "C");
        }

        return $pdf->Output('', 'S');
    }

    static public function estudiantesPorFechaRegistroPDF($fechaInicio, $fechaFin)
    {
        $estudiantes = Estudiante::listarPorFechaRegistro($fechaInicio, $fechaFin); // Método en el modelo Estudiante

        $pdf = new TCPDF();
        self::configurarCabeceraPDF($pdf, 'REPORTE DE ESTUDIANTES POR FECHA DE REGISTRO');

        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 6, 'Período: ' . date("d/m/Y", strtotime($fechaInicio)) . ' - ' . date("d/m/Y", strtotime($fechaFin)), 0, 1);

        $pdf->SetY(72);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(50, 8, 'Nombre', 1, '', "C");
        $pdf->Cell(60, 8, 'Correo', 1, '', "C");
        $pdf->Cell(28, 8, 'Teléfono', 1, '', "C");
        $pdf->Cell(38, 8, 'Fecha de Registro', 1, '', "C");
        $pdf->Ln();

        if ($estudiantes) {
            foreach ($estudiantes as $estudiante) {
                $fechaRegistro = date("d/m/Y", strtotime($estudiante['fecha_registro']));

                $pdf->Cell(50, 8, $estudiante['nombre'] . ' ' . $estudiante['apellidos'], 1);
                $pdf->Cell(60, 8, $estudiante['correo'], 1);
                $pdf->Cell(28, 8, $estudiante['telefono'], 1);
                $pdf->Cell(38, 8, $fechaRegistro, 1);
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(175, 8, 'No se encontraron estudiantes para el período seleccionado.', 0, 0, "C");
        }

        return $pdf->Output('', 'S');
    }

    static public function estudiantesPorCursoPDF($idCurso)
    {
        $curso = Curso::buscarPorId($idCurso);
        $estudiantes = Estudiante::listarPorCurso($idCurso);

        $pdf = new TCPDF();
        self::configurarCabeceraPDF($pdf, 'REPORTE DE ESTUDIANTES POR CURSO');
        $pdf->SetY(50);

        $pdf->SetFont('helvetica', '', 11);

        $pdf->Cell(50, 8, 'Nombre', 1, '', "C");
        $pdf->Cell(60, 8, 'Correo', 1, '', "C");
        $pdf->Cell(25, 8, 'Teléfono', 1, '', "C");
        $pdf->Cell(50, 8, 'Apoderado', 1, '', "C");
        $pdf->Ln();

        if ($curso && $estudiantes) {
            foreach ($estudiantes as $estudiante) {
                $pdf->Cell(50, 8, $estudiante['nombre'] . ' ' . $estudiante['apellidos'], 1);
                $pdf->Cell(60, 8, $estudiante['correo'], 1);
                $pdf->Cell(25, 8, $estudiante['telefono'], 1);
                $pdf->Cell(50, 8, $estudiante['apoderado'], 1);
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(175, 8, 'No se encontraron estudiantes para el curso seleccionado.', 0, 0, "C");
        }

        return $pdf->Output('', 'S');
    }

    static public function estudiantesCuotasNoPagadasPDF()
    {
        $estudiantes = Estudiante::listarConCuotasPendientes();
        $pdf = new TCPDF();
        self::configurarCabeceraPDF($pdf, 'REPORTE DE ESTUDIANTES CON CUOTAS NO PAGADAS');

        $pdf->SetY(55);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(55, 8, 'Estudiante', 1, '', "C");
        $pdf->Cell(30, 8, 'Curso', 1, '', "C");
        $pdf->Cell(38, 8, 'Cuotas Pendientes', 1, '', "C");
        $pdf->Cell(38, 8, 'Monto Total (Bs)', 1, '', "C");
        $pdf->Ln();

        if ($estudiantes) {
            foreach ($estudiantes as $estudiante) {
                $pdf->Cell(55, 8, $estudiante['nombre'] . " " . $estudiante['apellidos'], 1);
                $pdf->Cell(30, 8, $estudiante['curso'], 1, '', 'C');
                $pdf->Cell(38, 8, $estudiante['cuotas_pendientes'], 1, '', 'C');
                $pdf->Cell(38, 8, number_format($estudiante['monto_total_pendiente'], 2), 1, '', 'R');
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(175, 8, 'No se encontraron estudiantes con cuotas pendientes.', 0, 0, "C");
        }
        return $pdf->Output('', 'S');
    }

    static public function estudiantesDeudoresPorCursoPDF($idCurso)
    {
        $estudiantes = Estudiante::listarConCuotasPendientesPorCurso($idCurso);
        $pdf = new TCPDF();
        self::configurarCabeceraPDF($pdf, 'REPORTE DE DEUDORES POR CURSO');

        $pdf->SetY(55);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(55, 8, 'Estudiante', 1, '', "C");
        $pdf->Cell(34, 8, 'Curso', 1, '', "C");
        $pdf->Cell(38, 8, 'Cuotas Pendientes', 1, '', "C");
        $pdf->Cell(38, 8, 'Monto Total (Bs)', 1, '', "C");
        $pdf->Ln();

        if ($estudiantes) {
            foreach ($estudiantes as $estudiante) {
                $pdf->Cell(55, 8, $estudiante['nombre'] . " " . $estudiante['apellidos'], 1);
                $pdf->Cell(34, 8, $estudiante['curso'], 1, '', 'C');
                $pdf->Cell(38, 8, $estudiante['cuotas_pendientes'], 1, '', 'C');
                $pdf->Cell(38, 8, number_format($estudiante['monto_total_pendiente'], 2), 1, '', 'R');
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(175, 8, 'No se encontraron estudiantes con cuotas pendientes.', 0, 0, "C");
        }
        return $pdf->Output('', 'S');
    }

    static public function cursosConMasEstudiantesPDF()
    {
        $cursos = Curso::listarConMasEstudiantes();
        $pdf = new TCPDF();
        self::configurarCabeceraPDF($pdf, 'REPORTE DE CURSOS CON MAYOR NÚMERO DE ESTUDIANTES');

        $pdf->SetY(55);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(60, 8, 'Curso', 1, '', "C");
        $pdf->Cell(60, 8, 'Paralelo', 1, '', "C");
        $pdf->Cell(60, 8, 'Cantidad de Estudiantes', 1, '', "C");
        $pdf->Ln();

        if ($cursos) {
            foreach ($cursos as $curso) {
                $pdf->Cell(60, 8, $curso['nombre'], 1);
                $pdf->Cell(60, 8, $curso['paralelo'], 1, '', 'C');
                $pdf->Cell(60, 8, $curso['cantidad_estudiantes'], 1, '', 'R');
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(175, 8, 'No se encontraron cursos con estudiantes.', 0, 0, "C");
        }

        return $pdf->Output('', 'S');
    }

    static public function pagosPorApoderadoPDF($idApoderado)
    {
        $pagos = Pago::listarPorApoderado($idApoderado);
        $apoderado = Apoderado::buscarPorId($idApoderado);

        $pdf = new TCPDF();
        self::configurarCabeceraPDF($pdf, 'REPORTE DE PAGOS POR APODERADO');

        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 6, 'Apoderado: ' . $apoderado['nombre'] . ' ' . $apoderado['apellido'], 0, 1);
        $pdf->Cell(0, 6, 'Dirección: ' . $apoderado['direccion'], 0, 1);
        $pdf->Cell(0, 6, 'Teléfono: ' . $apoderado['telefono'], 0, 1);

        $pdf->SetY(72);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(30, 8, 'Código', 1, '', "C");
        $pdf->Cell(35, 8, 'Fecha', 1, '', "C");
        $pdf->Cell(50, 8, 'Estudiante', 1, '', "C");
        $pdf->Cell(40, 8, 'Monto (Bs)', 1, '', "C");
        $pdf->Ln();

        if ($pagos) {
            foreach ($pagos as $pago) {
                $estudiante = Estudiante::listar('id', $pago['id_estudiante']);
                $fecha = date_create($pago["fecha"]);
                $fechaFormateada = date_format($fecha, "d/m/y H:i");

                $pdf->Cell(30, 8, $pago['codigo'], 1);
                $pdf->Cell(35, 8, $fechaFormateada, 1);
                $pdf->Cell(50, 8, $estudiante['nombre'] . ' ' . $estudiante['apellidos'], 1);
                $pdf->Cell(40, 8, $pago['monto_total'], 1, '', 'R');
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(175, 8, 'No se encontraron pagos para el apoderado seleccionado.', 0, 0, "C");
        }

        return $pdf->Output('', 'S');
    }

    static public function estudiantesMayorPagoPDF()
    {
        $estudiantes = Pago::listarEstudiantesMayorPago();

        $pdf = new TCPDF();
        self::configurarCabeceraPDF($pdf, 'REPORTE DE ESTUDIANTES CON MAYOR MONTO DE PAGO');

        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetY(60);
        $pdf->SetFont('helvetica', '', 11);

        $pdf->Cell(40, 8, 'Código pago', 1, '', "C");
        $pdf->Cell(50, 8, 'Estudiante', 1, '', "C");
        $pdf->Cell(50, 8, 'Apoderado', 1, '', "C");
        $pdf->Cell(30, 8, 'Monto (Bs)', 1, '', "C");
        $pdf->Ln();

        if ($estudiantes) {
            foreach ($estudiantes as $estudiante) {
                $pdf->Cell(40, 8, $estudiante['codigo_pago'], 1);
                $pdf->Cell(50, 8, $estudiante['estudiante'], 1);
                $pdf->Cell(50, 8, $estudiante['apoderado'], 1);
                $pdf->Cell(30, 8, $estudiante['monto_total'], 1, '', 'R');
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(175, 8, 'No se encontraron datos de estudiantes con pagos registrados.', 0, 0, "C");
        }

        return $pdf->Output('', 'S');
    }

    static public function cuotasPendientesDetalladoPorEstudiantePDF($idEstudiante)
    {
        $cuotasPendientes = Cuota::cuotasPendientesDetalladoPorEstudiante($idEstudiante);

        $pdf = new TCPDF();
        self::configurarCabeceraPDF($pdf, 'REPORTE DETALLADO DE CUOTAS PENDIENTES POR ESTUDIANTE');

        $pdf->SetY(55);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(60, 8, 'Estudiante', 1, '', "C");
        $pdf->Cell(30, 8, 'Curso', 1, '', "C");
        $pdf->Cell(20, 8, 'Gestión', 1, '', "C");
        $pdf->Cell(20, 8, 'Mes', 1, '', "C");
        $pdf->Cell(30, 8, 'Fecha Venc.', 1, '', "C");
        $pdf->Cell(30, 8, 'Monto (Bs)', 1, '', "C");
        $pdf->Ln();

        if ($cuotasPendientes) {
            foreach ($cuotasPendientes as $cuota) {
                $pdf->Cell(60, 8, $cuota['estudiante'], 1);
                $pdf->Cell(30, 8, $cuota['curso'], 1, '', 'C');
                $pdf->Cell(20, 8, $cuota['gestion'], 1, '', 'C');
                $pdf->Cell(20, 8, $cuota['mes'], 1, '', 'C');
                $pdf->Cell(30, 8, date('d/m/Y', strtotime($cuota['fecha_vencimiento'])), 1, '', 'C');
                $pdf->Cell(30, 8, number_format($cuota['monto_cuota'], 2), 1, '', 'R');
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(190, 8, 'No se encontraron cuotas pendientes para este estudiante.', 0, 0, "C");
        }
        return $pdf->Output('', 'S');
    }

    static public function cuotasPendientesPorPeriodoPDF($fechaInicio, $fechaFin)
    {
        // Obtener datos de los estudiantes con cuotas pendientes en el periodo
        $cuotasPendientes = Cuota::cuotasPendientesPorPeriodo($fechaInicio, $fechaFin);

        // Crear el PDF y configurar la cabecera
        $pdf = new TCPDF();
        self::configurarCabeceraPDF($pdf, 'REPORTE DE DEUDORES POR PERIODO');

        $pdf->SetFont('helvetica', '', 11);
        $pdf->SetY(45);
        $pdf->Cell(0, 6, 'Período: ' . date("d/m/Y", strtotime($fechaInicio)) . ' - ' . date("d/m/Y", strtotime($fechaFin)), 0, 1);
        // Configurar tabla de encabezado
        $pdf->SetY(55);

        $pdf->Cell(55, 8, 'Estudiante', 1, '', "C");
        $pdf->Cell(30, 8, 'Curso', 1, '', "C");
        $pdf->Cell(35, 8, 'Mes', 1, '', "C");
        $pdf->Cell(30, 8, 'Fecha Venc.', 1, '', "C");
        $pdf->Cell(28, 8, 'Monto (Bs)', 1, '', "C");
        $pdf->Ln();

        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        if ($cuotasPendientes) {
            foreach ($cuotasPendientes as $cuota) {
                $pdf->Cell(55, 8, $cuota['estudiante'], 1);
                $pdf->Cell(30, 8, $cuota['curso'], 1, '', 'C');
                $nombreMes = $meses[(int)$cuota['mes']];
                $pdf->Cell(35, 8, $nombreMes, 1, '', 'C');
                $pdf->Cell(30, 8, date('d/m/Y', strtotime($cuota['fecha_vencimiento'])), 1, '', 'C');
                $pdf->Cell(28, 8, number_format($cuota['monto_cuota'], 2), 1, '', 'R');
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(190, 8, 'No se encontraron cuotas pendientes en el periodo especificado.', 0, 0, "C");
        }
        return $pdf->Output('', 'S');
    }
}
