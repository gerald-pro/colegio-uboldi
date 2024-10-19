<div class="content-wrapper p-4">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Reporte de Historial de Pagos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Reporte de Pagos</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Seleccione un estudiante</h3>
            </div>
            <div class="card-body">
                <form id="formReporte" method="post">
                    <div class="form-group">
                        <label for="idEstudiante">Estudiante:</label>
                        <select class="form-control" id="idEstudiante" name="idEstudiante" required>
                            <option value="">Seleccione un estudiante</option>
                            <?php
                            $estudiantes = Estudiante::listar();
                            foreach ($estudiantes as $estudiante) {
                                echo "<option value='{$estudiante['id']}'>{$estudiante['nombre']} {$estudiante['apellidos']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Generar Reporte</button>
                </form>
            </div>
        </div>

        <div id="resultadoReporte" class="mt-4">

        </div>
        <div class='mt-3'>
            <button class='btn btn-success mr-2' onclick='generarPDF()'>Generar PDF</button>
            <!-- <button class='btn btn-primary' onclick='generarExcel()'>Generar Excel</button> -->
        </div>
    </section>
</div>