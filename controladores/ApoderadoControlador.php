<?php

class ApoderadoControlador {

    /*=============================================
    REGISTRO DE APODERADO
    =============================================*/

    static public function crear(){

        if(isset($_POST["NuevoNombre"])){

            if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["NuevoNombre"]) &&
               preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["NuevoApellido"]) &&
               preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["NuevaDireccion"]) &&
               preg_match('/^[0-9]+$/', $_POST["NuevoTelefono"])){

                $datos = array(
                               "nombre" => $_POST["NuevoNombre"],
                               "apellido" => $_POST["NuevoApellido"],
                               "direccion" => $_POST["NuevaDireccion"],
                               "telefono" => $_POST["NuevoTelefono"],
                               "id_usuario" => $_POST['NuevoIdUsuario']
                               );

                $respuesta = Apoderado::crear($datos);

                if($respuesta == "ok"){
                    echo '<script>
                    swal({
                          type: "success",
                          title: "El apoderado ha sido registrado correctamente",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                                    if (result.value) {

                                    window.location = "apoderados";

                                    }
                                })

                    </script>';
                }   
            }else{
                echo '<script>

                    swal({
                          type: "error",
                          title: "¡Los campos no pueden ir vacíos y deben contener solo letras (nombre, apellido y dirección) o números (teléfono)!",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                            if (result.value) {

                            window.location = "apoderados";

                            }
                        })

                  </script>';


            }
        }
    }

    /*=============================================
    MOSTRAR APODERADO
    =============================================*/

    static public function listar($item = null, $valor = null){
        $respuesta = Apoderado::listar($item, $valor);

        return $respuesta;
    }

    /*=============================================
    EDITAR APODERADO
    =============================================*/

    static public function editar(){

        if(isset($_POST["EditarNombre"])){

            if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["EditarNombre"]) &&
               preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["EditarApellido"]) &&
               preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["EditarDireccion"]) &&
               preg_match('/^[0-9]+$/', $_POST["EditarTelefono"]) &&
               preg_match('/^[0-9]+$/', $_POST["EditarIdUsuario"])){

                $datos = array("nombre" => $_POST["EditarNombre"],
                               "apellido" => $_POST["EditarApellido"],
                               "direccion" => $_POST["EditarDireccion"],
                               "telefono" => $_POST["EditarTelefono"],
                               "id_usuario" => $_POST["EditarIdUsuario"],
                               "id" => $_POST["IdApoderado"]);

                $respuesta = Apoderado::editar($datos);

                if($respuesta == "ok"){

                    echo'<script>

                    swal({
                          type: "success",
                          title: "El apoderado ha sido editado correctamente",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                                    if (result.value) {

                                    window.location = "apoderados";

                                    }
                                })

                    </script>';

                }
            }else{

                echo'<script>

                    swal({
                          type: "error",
                          title: "¡Los campos no pueden ir vacíos y deben contener solo letras (nombre, apellido y dirección) o números (teléfono)!",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                            if (result.value) {

                            window.location = "apoderados";

                            }
                        })

                  </script>';
            }
        }
    }

    /*=============================================
    BORRAR APODERADO
    =============================================*/

    static public function eliminar(){

        if(isset($_GET["id"])){
            $datos = $_GET["id"];

            $respuesta = Apoderado::eliminar($datos);

            if($respuesta == "ok"){

                echo'<script>

                swal({
                      type: "success",
                      title: "El apoderado ha sido borrado correctamente",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar"
                      }).then(function(result){
                                if (result.value) {

                                window.location = "apoderados";

                                }
                            })

                </script>';

            }       

        }

    }

}
