<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Usuarios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Usuarios</li>
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


                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">Registrar Usuario</button>


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

                <table class="table table-bordered table-hover dataTable dtr-inline tablas" aria-describedby="example2_info">
                    
                    <thead>
                        
                        <tr>
                            
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Motor de renderizado: actívelo para ordenar las columnas de forma descendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">#</font>
                                </font>
                            </th>

                           
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Versión del motor: activar para ordenar columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Usuario</font>
                                </font>
                            </th>

                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Versión del motor: activar para ordenar columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Correo</font>
                                </font>
                            </th>

                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Versión del motor: activar para ordenar columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Fecha ultima_sesion</font>
                                </font>
                            </th>

                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Versión del motor: activar para ordenar columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Acciones</font>
                                </font>
                            </th>


                            

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $item = null;
                        $valor = null;

                        $usuarios = UsuarioControlador::listar($item, $valor);

                        foreach ($usuarios as $key => $value) {

                            echo ' <tr>
                            <td>' . ($key + 1) . '</td>
                            <td>' . $value["usuario"] . '</td>
                            <td>' . $value["correo"] . '</td>
                            <td>' . $value["fecha_registro"] . '</td>
                            <td>
                                <div class="btn-group">
                                <button class="btn btn-warning btnEditarUsuario" id="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-solid fa-pen" style="color: white;"></i></button>
                                <button class="btn btn-danger btnEliminarUsuario" id="' . $value["id"] . '" usuario="' . $value["usuario"] . '"><i class="fa fa-trash" style="color: white;"></i></i></button>
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






<div class="modal fade" id="modalAgregarUsuario">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <form role="form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">usuario</font>
                            </font>
                        </label>
                        <input type="text" class="form-control" id="NuevoUsuario" name="NuevoUsuario" placeholder="Ingrese usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Contraseña</font>
                            </font>
                        </label>
                        <input type="password" class="form-control" id="NuevaPassword" name="NuevaPassword" placeholder="Ingrese Password" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">correo</font>
                            </font>
                        </label>
                        <input type="text" class="form-control" id="NuevoCorreo" name="NuevoCorreo" placeholder="Ingrese correo" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">fecha</font>
                            </font>
                        </label>
                        <input type="date" class="form-control" id="NuevaFecha" name="NuevaFecha" placeholder="Ingrese Password" required>
                    </div>

                   

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Guardar</button>
                </div>

                <?php

               $crearUsuarios = new UsuarioControlador();
                $crearUsuarios->ctrCrearUsuario();

                ?>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade" id="modalEditarUsuario">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <form role="form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">usuario</font>
                            </font>
                        </label>
                        <input type="text" class="form-control" id="EditarUsuario" name="EditarUsuario" placeholder="Ingrese usuario" value="" readonly>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">correo</font>
                            </font>
                        </label>
                        <input type="text" class="form-control" id="EditarCorreo" name="EditarCorreo" placeholder="Ingrese correo" value="" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">fecha</font>
                            </font>
                        </label>
                        <input type="date" class="form-control" id="EditarFecha" name="EditarFecha" placeholder="Ingrese fecha" required>
                        <input type="hidden" id="fecha" name="fecha">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Guardar</button>
                </div>

                <?php
                $editarUsuarios = new UsuarioControlador();
                $editarUsuarios->ctrEditarUsuario();
                ?>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<?php
$borrarUsuarios = new UsuarioControlador();
$borrarUsuarios->ctrBorrarUsuario();
?>