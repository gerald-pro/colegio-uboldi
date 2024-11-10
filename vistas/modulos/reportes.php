<div class="content-wrapper p-4">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Reportes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Reportes</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <!-- Pagos por estudiante -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pagos por estudiante</h3>
                    </div>
                    <div class="card-body">
                        <form id="formReporte" method="post">
                            <div class="form-row align-items-center">
                                <!-- Select del estudiante -->
                                <div class="input-group">
                                    <select class="form-control select2" id="idEstudiante" name="idEstudiante" required>
                                        <option value="">Seleccione un estudiante</option>
                                        <?php
                                        $estudiantes = Estudiante::listar();
                                        foreach ($estudiantes as $estudiante) {
                                            echo "<option value='{$estudiante['id']}'>{$estudiante['nombre']} {$estudiante['apellidos']}</option>";
                                        }
                                        ?>
                                    </select>

                                    <div class="input-group-append">
                                        <!-- <button type="button" class="btn btn-primary" onclick="verReporte()">Ver Reporte</button> -->
                                        <button type="button" class="btn btn-success" onclick="generarPDF()"><i class="fa fa-download" aria-hidden="true"></i></button>
                                    </div>
                                </div>

                                <!-- Botones a la derecha -->

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Estudiantes por apoderado -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Estudiantes por apoderado</h3>
                    </div>
                    <div class="card-body">
                        <form id="formReporte" method="post">
                            <div class="form-row align-items-center">
                                <!-- Select del estudiante -->
                                <div class="input-group">
                                    <select class="form-control select2" id="idApoderado" name="idApoderado" required>
                                        <option value="">Seleccione un apoderado</option>
                                        <?php
                                        $apoderados = Apoderado::listar();
                                        foreach ($apoderados as $item) {
                                            echo "<option value='{$item['id']}'>{$item['nombre']} {$item['apellido']}</option>";
                                        }
                                        ?>
                                    </select>

                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success" onclick="generarRepEstudiantesXApoderadoPDF()"><i class="fa fa-download" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Cuotas por apoderado -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Cuotas por apoderado</h3>
                    </div>
                    <div class="card-body">
                        <form id="formCuotasApoderado" method="post">
                            <div class="form-row align-items-center">
                                <div class="input-group">
                                    <select class="form-control select2" id="idApoderadoCuota" name="idApoderadoCuota" required>
                                        <option value="">Seleccione un apoderado</option>
                                        <?php
                                        $apoderados = Apoderado::listar();
                                        foreach ($apoderados as $item) {
                                            echo "<option value='{$item['id']}'>{$item['nombre']} {$item['apellido']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success" onclick="generarCuotasPorApoderadoPDF()"><i class="fa fa-download" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Pagos realizados por período -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pagos realizados por período</h3>
                    </div>
                    <div class="card-body">
                        <form id="formReportePeriodo" method="post">
                            <div class="form-row align-items-center">
                                <div class="col">
                                    <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required placeholder="Fecha Inicio">
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control" id="fechaFin" name="fechaFin" required placeholder="Fecha Fin">
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-success" onclick="generarPagosPorPeriodoPDF()"><i class="fa fa-download" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Estudiantes por fecha de registro -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Estudiantes por fecha de registro</h3>
                    </div>
                    <div class="card-body">
                        <form id="formReporteRegistro" method="post">
                            <div class="form-row align-items-center">
                                <div class="col">
                                    <input type="date" class="form-control" id="fechaInicioRegistro" name="fechaInicioRegistro" required placeholder="Fecha Inicio">
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control" id="fechaFinRegistro" name="fechaFinRegistro" required placeholder="Fecha Fin">
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-success" onclick="generarEstudiantesPorFechaPDF()"><i class="fa fa-download" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Estudiantes por curso -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Estudiantes por curso</h3>
                    </div>
                    <div class="card-body">
                        <form id="formReporteCurso" method="post">
                            <div class="form-row align-items-center">
                                <div class="input-group">
                                    <select class="form-control select2" id="idCurso" name="idCurso" required>
                                        <option value="">Seleccione un curso</option>
                                        <?php
                                        $cursos = Curso::listar();
                                        foreach ($cursos as $curso) {
                                            echo "<option value='{$curso['id']}'>{$curso['nombre']} - {$curso['paralelo']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success" onclick="generarEstudiantesPorCursoPDF()"><i class="fa fa-download" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Reporte de estudiantes con cuotas no pagadas -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Reporte de estudiantes con cuotas no pagadas</h3>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-danger" onclick="generarEstudiantesCuotasPendientesPDF()"><i class="fa fa-download" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>

            <!-- Cuotas pendientes por estudiante -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Cuotas pendientes por estudiante</h3>
                    </div>
                    <div class="card-body">
                        <form id="formReporteCurso" method="post">
                            <div class="form-row align-items-center">
                                <div class="input-group">
                                    <select class="form-control select2" id="idEstudianteCuotasPendientes" name="idEstudianteCuotasPendientes" required>
                                        <option value="">Seleccione un estudiante</option>
                                        <?php
                                        $estudiantes = Estudiante::listar();
                                        foreach ($estudiantes as $item) {
                                            echo "<option value='{$item['id']}'>{$item['nombre']} {$item['apellido']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success" onclick="generarCuotasPendientesPorEstudiantePDF()"><i class="fa fa-download" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Reporte de cuotas pendientes por periodo -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Reporte de estudiantes deudores por curso</h3>
                    </div>
                    <div class="card-body">
                        <form id="formReporteCurso" method="post">
                            <div class="form-row align-items-center">
                                <div class="input-group">
                                    <select class="form-control select2" id="idCursoDeudores" name="idCursoDeudores" required>
                                        <option value="">Seleccione un curso</option>
                                        <?php
                                        $cursos = Curso::listar();
                                        foreach ($cursos as $curso) {
                                            echo "<option value='{$curso['id']}'>{$curso['nombre']} - {$curso['paralelo']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success" onclick="generarEstudiantesDeudoresPorCursoPDF()"><i class="fa fa-download" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Reporte de deudores por período -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Deudaores por período</h3>
                    </div>
                    <div class="card-body">
                        <form id="formReportePeriodo" method="post">
                            <div class="form-row align-items-center">
                                <div class="col">
                                    <input type="date" class="form-control" id="fechaInicioCuotasPendientes" name="fechaInicioCuotasPendientes" required placeholder="Fecha Inicio">
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control" id="fechaFinCuotasPendientes" name="fechaFinCuotasPendientes" required placeholder="Fecha Fin">
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-success" onclick="generarCuotasPendientesPorPeriodoPDF()"><i class="fa fa-download" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Reporte de cursos con mayor número de estudiantes -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Reporte de cursos con mayor número de estudiantes</h3>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" onclick="generarCursosConMasEstudiantesPDF()">Descargar PDF</button>
                    </div>
                </div>
            </div>

            <!-- Reporte de pagos por apoderado -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Reporte de pagos por apoderado</h3>
                    </div>
                    <div class="card-body">
                        <form id="formReportePorApoderado">
                            <div class="form-row align-items-center">
                                <div class="input-group">
                                    <select class="form-control" id="idPagosPorApoderado" name="idPagosPorApoderado" required>
                                        <option value="">Seleccione un apoderado</option>
                                        <?php
                                        $apoderados = Apoderado::listar();
                                        foreach ($apoderados as $apoderado) {
                                            echo "<option value='{$apoderado['id']}'>{$apoderado['nombre']} {$apoderado['apellido']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success" onclick="generarPagosPorApoderadoPDF()"><i class="fa fa-download" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Estudiantes con mayor monto de pago -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Estudiantes con mayor monto de pago</h3>
                    </div>
                    <div class="card-body">
                        <form id="formReporteEstudiantesMayorPago">
                            <div class="form-row align-items-center">
                                <div class="input-group">
                                    <button type="button" class="btn btn-primary" onclick="generarEstudiantesMayorPagoPDF()">
                                        Descargar PDF
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalReporte" tabindex="-1" role="dialog" aria-labelledby="modalReporteLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReporteLabel">Historial de Pagos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="contenidoReporte">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>