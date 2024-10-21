<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Cuotas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Cuotas</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-header">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCuota">Registrar Cuota</button>

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
              <th>Gestión</th>
              <th>Mes</th>
              <th>Monto</th>
              <th>Fecha de Vencimiento</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $items = CuotaControlador::listar();

            foreach ($items as $key => $value) {
              echo '
                <tr>
                    <td>' . ($key + 1) . '</td>
                    <td>' . $value["gestion"] . '</td>
                    <td>' . $value["mes"] . '</td>
                    <td>' . $value["monto"] . '</td>
                    <td>' . $value["fecha_vencimiento"] . '</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-warning btnEditarCuota" id="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditarCuota"><i class="fa fa-solid fa-pen" style="color: white;"></i></button>
                            <button class="btn btn-danger btnEliminarCuota" id="' . $value["id"] . '"><i class="fa fa-trash" style="color: white;"></i></button>
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

<!-- Modal agregar cuota -->
<div class="modal fade" id="modalAgregarCuota">
  <div class="modal-dialog">
    <div class="modal-content bg-danger">
      <form role="form" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Registrar Cuota</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12 form-group">
                <label for="nuevaGestion">Gestión</label>
                <input type="number" class="form-control" id="nuevaGestion" name="nuevaGestion" required min="2000" max="2099" step="1" value="2024">
              </div>

              <div class="col-md-6 form-group">
                <label for="nuevoMes">Mes</label>
                <input type="number" class="form-control" id="nuevoMes" name="nuevoMes" required min="1" max="12" step="1" placeholder="Ej. 1 para Enero">
              </div>

              <div class="col-md-6 form-group">
                <label for="nuevoMonto">Monto</label>
                <input type="number" class="form-control" id="nuevoMonto" name="nuevoMonto" required placeholder="Ingrese el monto">
              </div>

              <div class="col-md-12 form-group">
                <label for="nuevaFechaVencimiento">Fecha de Vencimiento</label>
                <input type="date" class="form-control" id="nuevaFechaVencimiento" name="nuevaFechaVencimiento" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-outline-light">Guardar</button>
        </div>
        <?php
        $registro = new CuotaControlador();
        $registro->crear();
        ?>
      </form>
    </div>
  </div>
</div>

<!-- Modal editar cuota -->
<div class="modal fade" id="modalEditarCuota">
  <div class="modal-dialog">
    <div class="modal-content bg-danger">
      <form role="form" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Editar Cuota</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 form-group">
                <label for="editarGestion">Gestión</label>
                <input type="number" class="form-control" id="editarGestion" name="editarGestion" required min="2000" max="2099" step="1" value="2024">
              </div>

              <div class="col-md-6 form-group">
                <label for="editarMes">Mes</label>
                <input type="number" class="form-control" id="editarMes" name="editarMes" required min="1" max="12" step="1">
              </div>

              <div class="col-md-6 form-group">
                <label for="editarMonto">Monto</label>
                <input type="number" class="form-control" id="editarMonto" name="editarMonto" required placeholder="Ingrese el monto">
              </div>

              <div class="col-md-6 form-group">
                <label for="editarFechaVencimiento">Fecha de Vencimiento</label>
                <input type="date" class="form-control" id="editarFechaVencimiento" name="editarFechaVencimiento" required>
              </div>
              <input type="hidden" id="editarId" name="editarId">
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-outline-light">Guardar Cambios</button>
        </div>
        <?php
        $editar = new CuotaControlador();
        $editar->editar();
        ?>
      </form>
    </div>
  </div>
</div>

<?php
$borrar = new CuotaControlador();
$borrar->eliminar();
?>