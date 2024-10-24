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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Reporte de pagos por estudiante</h3>
            </div>
            <div class="card-body">
                <form id="formReporte" method="post">
                    <div class="form-row align-items-center">
                        <!-- Select del estudiante -->
                        <div class="input-group">
                            <select class="form-control" id="idEstudiante" name="idEstudiante" required>
                                <option value="">Seleccione un estudiante</option>
                                <?php
                                $estudiantes = Estudiante::listar();
                                foreach ($estudiantes as $estudiante) {
                                    echo "<option value='{$estudiante['id']}'>{$estudiante['nombre']} {$estudiante['apellidos']}</option>";
                                }
                                ?>
                            </select>

                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" onclick="verReporte()">Ver Reporte</button>
                                <button type="button" class="btn btn-success" onclick="generarPDF()">Descargar PDF</button>
                            </div>
                        </div>

                        <!-- Botones a la derecha -->

                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Reporte de estudiantes por apoderado</h3>
            </div>
            <div class="card-body">
                <form id="formReporte" method="post">
                    <div class="form-row align-items-center">
                        <!-- Select del estudiante -->
                        <div class="input-group">
                            <select class="form-control" id="idApoderado" name="idApoderado" required>
                                <option value="">Seleccione un apoderado</option>
                                <?php
                                $apoderados = Apoderado::listar();
                                foreach ($apoderados as $item) {
                                    echo "<option value='{$item['id']}'>{$item['nombre']} {$item['apellido']}</option>";
                                }
                                ?>
                            </select>

                            <div class="input-group-append">
                                <button type="button" class="btn btn-success" onclick="generarRepEstudiantesXApoderadoPDF()">Descargar PDF</button>
                            </div>
                        </div>
                    </div>
                </form>
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