<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Cursos</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
						<li class="breadcrumb-item active">Curso</li>
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
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCurso">
					Registrar Curso
				</button>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
						<i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
						<i class="fas fa-times"></i>
					</button>
				</div>
			</div><!-- /.card-header -->

			<div class="card-body">
				<table class="table table-bordered table-hover dataTable dtr-inline tablas"
					aria-describedby="example2_info">
					<thead>
						<tr>
							<!-- # -->
							<th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
								colspan="1" aria-sort="ascending"
								aria-label="Motor de renderizado: actívelo para ordenar las columnas de forma descendente">
								<font style="vertical-align: inherit;">
									<font style="vertical-align: inherit;">#</font>
								</font>
							</th>

							<!-- Curso -->
							<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
								aria-label="Curso: activar para ordenar las columnas de forma ascendente">
								<font style="vertical-align: inherit;">
									<font style="vertical-align: inherit;">Curso</font>
								</font>
							</th>

							<!-- Paralelo -->
							<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
								aria-label="Paralelo: activar para ordenar la columna de forma ascendente">
								<font style="vertical-align: inherit;">
									<font style="vertical-align: inherit;">Paralelo</font>
								</font>
							</th>

							<!-- Acciones -->
							<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
								aria-label="Acciones: activar para ordenar las columnas de forma ascendente">
								<font style="vertical-align: inherit;">
									<font style="vertical-align: inherit;">Acciones</font>
								</font>
							</th>
						</tr>
					</thead>

					<tbody>
						<?php
						$curso = CursoControlador::listar();

						foreach ($curso as $key => $value) {
							echo
								'<tr>
									<td>' . ($key + 1) . '</td>
									<td class="text-uppercase">' . $value["nombre"] . '</td>
									<td class="text-uppercase">' . $value["paralelo"] . '</td>
									<td>
										<div class="btn-group">
											<button class="btn btn-warning btnEditarCurso" idCurso="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditarCurso"><i class="fa fa-solid fa-pen"style="color: white;"></i></button>
											<button class="btn btn-danger btnEliminarCurso" idCurso="' . $value["id"] . '"><i class="fa fa-trash"style="color: white;"></i></button>
										</div>
									</td>
        						</tr>';
						}
						?>
					</tbody>
				</table>

			</div><!-- /.card-body -->

		</div><!-- /.card -->

	</section><!-- /.content -->

</div><!-- /.content-wrapper -->

<!-- MODAL PARA AGREGAR NUEVO CURSO -->
<div class="modal fade" id="modalAgregarCurso">
	<div class="modal-dialog">
		<div class="modal-content bg-danger">
			<form role="form" method="post">
				<div class="modal-header">
					<h4 class="modal-title">Registrar Curso</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>

				<div class="modal-body">
					<!-- Curso -->
					<div class="form-group">
						<label for="nuevoCurso">
							<font style="vertical-align: inherit;">
								<font style="vertical-align: inherit;">Curso</font>
							</font>
						</label>
						<input type="text" class="form-control" id="nuevoCurso" name="nuevoCurso"
							placeholder="Ingrese Curso">
					</div>

					<!-- Paralelo -->
					<div class="form-group">
						<label for="nuevoParalelo">
							<font style="vertical-align: inherit;">
								<font style="vertical-align: inherit;">Paralelo</font>
							</font>
						</label>
						<input type="text" class="form-control" id="nuevoParalelo" name="nuevoParalelo"
							placeholder="Ingrese Paralelo">
					</div>
				</div>

				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-outline-light">Guardar</button>
				</div>

				<?php
				$crearCurso = new CursoControlador();
				$crearCurso->crear();
				?>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- MODAL PARA EDITAR UN CURSO -->
<div class="modal fade" id="modalEditarCurso">
	<div class="modal-dialog">
		<div class="modal-content bg-danger">
			<form role="form" method="post">
				<div class="modal-header">
					<h4 class="modal-title">Editar Curso</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>

				<div class="modal-body">
					<!-- Curso -->
					<div class="form-group">
						<label for="editarCurso">
							<font style="vertical-align: inherit;">
								<font style="vertical-align: inherit;">Curso</font>
							</font>
						</label>
						<input type="text" class="form-control" id="editarCurso" name="editarCurso"
							placeholder="Ingrese Curso">
						<input type="hidden" name="idCurso" id="idCurso" required>
					</div>

					<!-- Paralelo -->
					<div class="form-group">
						<label for="editarParalelo">
							<font style="vertical-align: inherit;">
								<font style="vertical-align: inherit;">Paralelo</font>
							</font>
						</label>
						<input type="text" class="form-control" id="editarParalelo" name="editarParalelo"
							placeholder="Ingrese Paralelo">
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-outline-light">Editar</button>
				</div>

				<?php
				$editarCurso = new CursoControlador();
				$editarCurso->editar();
				?>

			</form>

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<?php
$borrar = new CursoControlador();
$borrar->eliminar();
?>