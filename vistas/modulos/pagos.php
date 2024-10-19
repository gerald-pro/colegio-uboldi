<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pagos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Pagos</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregar">Registrar Pago</button>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover dataTable tablas">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Codigo</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Monto</th>
                            <th>Estudiante</th>
                            <th>Tutor</th>
                            <th>Curso</th>
                            <th>Paralelo</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $items = PagoControlador::listar();

                        foreach ($items as $key => $value) {
                            $pago = Pago::listar('id', $value["codigo"]);
                            $estudiante = Estudiante::listar('id', $value["id_estudiante"]);
                            $apoderado = Apoderado::listar('id', $value["id_apoderado"]);
                            $curso = Curso::listar('id', $value["id_curso"]);

                            $usuario = Usuario::listar('id', $value["id_usuario"]);
                            $fecha = date_create($value["fecha"]);

                            $hora = date_format($fecha, "H:i");
                            $fechaFormateada = date_format($fecha, "d/m/Y");

                            echo '
                                <tr>
                                <td>' . ($key + 1) . '</td>
                                <td class="text-uppercase">' . $value["codigo"] . '</td>
                                <td class="text-uppercase">' . $fechaFormateada . '</td>
                                <td class="text-uppercase">' . $hora . '</td>
                                <td class="text-uppercase">' . $value["monto"] . '</td>
                                <td class="text-uppercase">' . $estudiante['nombre'] . ' ' . $estudiante['apellidos'] . '</td>
                                <td class="text-uppercase">' . $apoderado['nombre'] . ' ' . $apoderado['apellido'] . '</td>
                                <td class="text-uppercase">' . $curso['nombre'] . '</td>
                                <td class="text-uppercase">' . $curso['paralelo'] . '</td>
                                <td class="text-uppercase">' . $usuario['usuario'] . '</td>
                                <td>
                                    <div class="btn-group">
                                    <button class="btn btn-info btnVerPago" id="' . $value["id"] . '" data-toggle="modal" data-target="#modalMostrar"><i class="fa fa-solid fa-eye" style="color: white;"></i></button>' . '
                                    <button class="btn btn-warning btnEditarPago" id="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditar"><i class="fa fa-solid fa-pen" style="color: white;"></i></button>
                                    <button class="btn btn-danger btnEliminarPago" id="' . $value["id"] . '"><i class="fa fa-trash" style="color: white;"></i></button>' 
                                    . '
                                    </div>
                                </td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Modal agregar -->
<div class="modal fade" id="modalAgregar">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <form role="form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Pago</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="nuevoCpago">Código</label>
                                <input type="text" class="form-control" id="nuevoCpago" name="nuevoCpago" required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="nuevoGestion">Gestion</label>
                                <input type="number" class="form-control" id="nuevoGestion" name="nuevoGestion" required min="2000" max="2099" step="1" value="2024">
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="nuevoIdMetodo">Método de pago</label>
                                <select name="nuevoIdMetodo" id="nuevoIdMetodo" class="form-control" required>
                                    <?php
                                    $metodos = MetodoPago::listar();
                                    foreach ($metodos as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["metodo"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="nuevoMonto">Monto</label>
                                <input type="number" class="form-control" id="nuevoMonto" name="nuevoMonto" required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="nuevoIdCurso">Curso</label>
                                <select name="nuevoIdCurso" id="nuevoIdCurso" class="form-control" required>
                                    <?php
                                    $cursos = Curso::listar();
                                    foreach ($cursos as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["curso"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="nuevoIdEstudiante">Estudiante</label>
                                <select name="nuevoIdEstudiante" id="nuevoIdEstudiante" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <?php
                                    $estudiantes = Estudiante::listar();
                                    foreach ($estudiantes as $key => $value) {
                                        echo '<option value="' . $value["id"] . '" data-apoderado="' . $value["id_apoderado"] . '">' . $value["nombre"] . ' ' . $value["apellidos"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="nuevoIdApoderado">Tutor</label>
                                <select name="nuevoIdApoderado" id="nuevoIdApoderado" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <?php
                                    $apoderados = Apoderado::listar();
                                    foreach ($apoderados as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["nombre"] . ' ' . $value["apellido"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Guardar</button>
                </div>
                <?php
                $registro = new PagoControlador();
                $registro->crear();
                ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal editar -->
<div class="modal fade" id="modalEditar">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <form role="form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Pago</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="editarCodigo">Codigo Pago</label>
                                <input type="text" class="form-control" id="editarCodigo" name="editarCodigo" required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="editarMonto">Monto</label>
                                <input type="number" class="form-control" id="editarMonto" name="editarMonto" required>
                                <input type="hidden" name="idPago" id="idPago" required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="editarIdCurso">Curso</label>
                                <select name="editarIdCurso" id="editarIdCurso" class="form-control" required>
                                    <?php
                                    $cursos = Curso::listar();
                                    foreach ($cursos as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["curso"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="editarIdEstudiante">Estudiante</label>
                                <select name="editarIdEstudiante" id="editarIdEstudiante" class="form-control" required>
                                    <?php
                                    $estudiantes = Estudiante::listar();
                                    foreach ($estudiantes as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["nombre"] . ' ' . $value["apellidos"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="editarIdApoderado">Tutor</label>
                                <select name="editarIdApoderado" id="editarIdApoderado" class="form-control" required>
                                    <?php
                                    $apoderados = Apoderado::listar();
                                    foreach ($apoderados as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["nombre"] . ' ' . $value["apellido"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Guardar</button>
                </div>
                <?php
                $edicion = new PagoControlador();
                $edicion->editar();
                ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal mostrar -->
<div class="modal fade" id="modalMostrar">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-info">
            <div class="modal-header">
                <h4 class="modal-title">Información del Pago</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="verCpago">Código</label>
                            <input type="text" class="form-control" id="verCpago" name="verCpago" readonly>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="verFecha">Fecha</label>
                            <input type="date" class="form-control" id="verFecha" name="verFecha" readonly>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="verHora">Hora</label>
                            <input type="time" class="form-control" id="verHora" name="verHora" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="verMonto">Monto</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Bs</span>
                                </div>
                                <input type="text" class="form-control" id="verMonto" name="verMonto" readonly>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="verUsuario">Usuario</label>

                            <select name="verIdUsuario" id="verIdUsuario" class="form-control" disabled>
                                <?php
                                $usuarios = Usuario::listar();
                                foreach ($usuarios as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["usuario"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="verIdEstudiante">Estudiante</label>

                            <select name="verIdEstudiante" id="verIdEstudiante" class="form-control" disabled>
                                <?php
                                $estudiantes = Estudiante::listar();
                                foreach ($estudiantes as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["nombre"] . ' ' . $value["apellidos"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="verIdApoderado">Tutor</label>

                            <select name="verIdApoderado" id="verIdApoderado" class="form-control" disabled>
                                <?php
                                $apoderados = Apoderado::listar();
                                foreach ($apoderados as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["nombre"] . ' ' . $value["apellido"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-light btnVerDetallePago" data-toggle="modal" data-target="#modalDetallePago">Ver Detalle</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetallePago">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h4 class="modal-title">Detalle del Pago</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="detalleMetodo">Método de Pago</label>
                            <select name="detalleMetodo" id="detalleMetodo" class="form-control" disabled>
                                <?php
                                $metodos = MetodoPago::listar();
                                foreach ($metodos as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["metodo"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="detalleMonto">Monto</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Bs</span>
                                </div>
                                <input type="text" class="form-control" id="detalleMonto" readonly>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="detalleGestion">Gestión</label>
                            <input type="text" class="form-control" id="detalleGestion" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
     
<?php
$borrar = new PagoControlador();
$borrar->eliminar();
?>