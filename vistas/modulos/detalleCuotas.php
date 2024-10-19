<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Detalle cuotas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Detalle cuotas</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">


        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarDetallecuotas">Registrar
          Detalle cuotas</button>


        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-hover dataTable dtr-inline tablas" aria-describedby="example2_info">
          <thead>
            <tr>
              <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Motor de renderizado: actívelo para ordenar las columnas de forma descendente">
                <font style="vertical-align: inherit;">
                  <font style="vertical-align: inherit;">#</font>
                </font>
              </th>

              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Plataforma(s): activar para ordenar la columna de forma ascendente">
                <font style="vertical-align: inherit;">
                  <font style="vertical-align: inherit;">Código</font>
                </font>
              </th>

              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Calificación CSS: activar para ordenar las columnas de forma ascendente">
                <font style="vertical-align: inherit;">
                  <font style="vertical-align: inherit;">Gestión</font>
                </font>
              </th>

              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Calificación CSS: activar para ordenar las columnas de forma ascendente">
                <font style="vertical-align: inherit;">
                  <font style="vertical-align: inherit;">Monto</font>
                </font>
              </th>

              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Calificación CSS: activar para ordenar las columnas de forma ascendente">
                <font style="vertical-align: inherit;">
                  <font style="vertical-align: inherit;">Nº cuotas</font>
                </font>
              </th>

              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Calificación CSS: activar para ordenar las columnas de forma ascendente">
                <font style="vertical-align: inherit;">
                  <font style="vertical-align: inherit;">Acciones</font>
                </font>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
            $detalles = DetalleCuotasControlador::listar();

            foreach ($detalles as $index => $value) {
              echo '
              <tr>
                <td class="datetime-uppercase">' . $index + 1 . '</td>
                <td class="datetime-uppercase">' . $value["codigo"] . '</td>
                <td class="datetime-uppercase">' . $value["gestion"] . '</td>
                <td class="datetime-uppercase">' . $value["monto"] . '</td>
                <td class="datetime-uppercase">' . $value["n_cuotas"] . '</td>
                <td>
                  <div class="btn-group">
                      <button class="btn btn-warning btnEditarDetalleCuotas" id="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditarDetallecuotas"><i class="fa fa-solid fa-pen"style="color: #007bff;"></i></button>
                      <button class="btn btn-danger btnEliminarDetalleCuotas" id="' . $value["id"] . '"><i class="fa fa-trash"style="color: #007bff;"></i></button>
                  </div>
                </td>
              </tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<!-- ENTRADA-->


<div class="modal fade" id="modalAgregarDetallecuotas">
  <div class="modal-dialog">
    <div class="modal-content bg-danger">
      <form role="form" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Registrar Detalle cuotas</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label for="exampleInputEmail1">
              <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">Codigo</font>
              </font>
            </label>
            <input type="text" class="form-control" id="nuevoCodigo" name="nuevoCodigo" placeholder="Ingrese Codigo">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">
              <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">Gestion</font>
              </font>
            </label>
            <input type="text" class="form-control" id="nuevaGestion" name="nuevaGestion" placeholder="Ingrese Gestion">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">
              <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">Monto</font>
              </font>
            </label>
            <input type="number" class="form-control" id="nuevoMonto" name="nuevoMonto" placeholder="Ingrese Monto">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">
              <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">Nº cuotas</font>
              </font>
            </label>
            <input type="text" class="form-control" id="nuevoNCuotas" name="nuevoNCuotas" placeholder="Ingrese el Nº Cuotas">
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-outline-light">Guardar</button>
        </div>
      </form>
      <?php

      $crearDetallecuotas = new DetalleCuotasControlador();
      $crearDetallecuotas->crear();

      ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



<div class="modal fade" id="modalEditarDetallecuotas">
  <div class="modal-dialog">
    <div class="modal-content bg-danger">
      <form role="form" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Editar Detalle cuotas</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label for="exampleInputEmail1">
              <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">Codigo</font>
              </font>
            </label>
            <input type="text" class="form-control" id="editarCodigo" name="editarCodigo" placeholder="Ingrese Codigo">
            <input type="hidden" name="idDetalleCuota" id="idDetalleCuota" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">
              <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">Gestion</font>
              </font>
            </label>
            <input type="text" class="form-control" id="editarGestion" name="editarGestion" placeholder="Ingrese Gestion">
          </div>


          <div class="form-group">
            <label for="exampleInputEmail1">
              <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">Monto</font>
              </font>
            </label>
            <input type="number" class="form-control" id="editarMonto" name="editarMonto" placeholder="Ingrese Monto">
            <input type="hidden" name="id" id="id" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">
              <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;"> Nº cuotas</font>
              </font>
            </label>
            <input type="text" class="form-control" id="editarNcuotas" name="editarNcuotas" placeholder="Ingrese Nº cuotas">
            <input type="hidden" name="id" id="id" required>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-outline-light">Guardar</button>
        </div>

        <?php

        $editarDetallecuotas = new DetalleCuotasControlador();
        $editarDetallecuotas->editar();

        ?>

      </form>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<?php
$eliminar = new DetalleCuotasControlador();
$eliminar->eliminar();
?>