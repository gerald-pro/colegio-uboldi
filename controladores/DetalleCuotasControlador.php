<?php

class DetalleCuotasControlador {

    /*=============================================
    REGISTRO DE DETALLE DE CUOTA
    =============================================*/

    static public function crear(){

        if(isset($_POST["nuevoCodigo"])){

            if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoCodigo"]) &&
               preg_match('/^[0-9]+$/', $_POST["nuevaGestion"]) &&
               preg_match('/^[0-9]+$/', $_POST["nuevoMonto"]) &&
               preg_match('/^[0-9]+$/', $_POST["nuevoNCuotas"])){

                $datos = array(
                    "codigo" => $_POST["nuevoCodigo"],
                    "gestion" => $_POST["nuevaGestion"],
                    "monto" => $_POST["nuevoMonto"],
                    "n_cuotas" => $_POST["nuevoNCuotas"]
                );

                $respuesta = DetalleCuota::crear($datos);

                if($respuesta == "ok"){
                    echo '<script>
                    swal({
                          type: "success",
                          title: "El detalle de cuotas ha sido registrado correctamente",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                                    if (result.value) {

                                    window.location = "detalleCuotas";

                                    }
                                })

                    </script>';
                }   
            }else{
                echo '<script>

                    swal({
                          type: "error",
                          title: "¡Los campos no pueden ir vacíos y deben contener solo letras y números!",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                            if (result.value) {

                            window.location = "detalleCuotas";

                            }
                        })

                  </script>';


            }
        }
    }

    /*=============================================
    MOSTRAR DETALLES DE CUOTAS
    =============================================*/

    static public function listar($item = null, $valor = null){
        $respuesta = DetalleCuota::listar($item, $valor);

        return $respuesta;
    }

    /*=============================================
    EDITAR DETALLE DE CUOTA
    =============================================*/

    static public function editar(){

        if(isset($_POST["editarCodigo"])){

            if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarCodigo"]) &&
               preg_match('/^[0-9]+$/', $_POST["editarGestion"]) &&
               preg_match('/^[0-9]+$/', $_POST["editarMonto"]) &&
               preg_match('/^[0-9]+$/', $_POST["editarNcuotas"])){

                $datos = array(
                    "codigo" => $_POST["editarCodigo"],
                    "gestion" => $_POST["editarGestion"],
                    "monto" => $_POST["editarMonto"],
                    "n_cuotas" => $_POST["editarNcuotas"],
                    "id" => $_POST["idDetalleCuota"]
                );

                $respuesta = DetalleCuota::editar($datos);

                if($respuesta == "ok"){

                    echo'<script>

                    swal({
                          type: "success",
                          title: "El detalle de cuotas ha sido editado correctamente",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                                    if (result.value) {

                                    window.location = "detalleCuotas";

                                    }
                                })

                    </script>';

                }
            }else{

                echo'<script>

                    swal({
                          type: "error",
                          title: "¡Los campos no pueden ir vacíos y deben contener solo letras y números!",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                            if (result.value) {

                            window.location = "detalleCuotas";

                            }
                        })

                  </script>';
            }
        }
    }

    /*=============================================
    BORRAR DETALLE DE CUOTA
    =============================================*/

    static public function eliminar(){

        if(isset($_GET["id"])){
            $datos = $_GET["id"];

            $respuesta = DetalleCuota::eliminar($datos);

            if($respuesta == "ok"){

                echo'<script>

                swal({
                      type: "success",
                      title: "El detalle de cuotas ha sido borrado correctamente",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar"
                      }).then(function(result){
                                if (result.value) {

                                window.location = "detalleCuotas";

                                }
                            })

                </script>';
            }       
        }
    }
}
