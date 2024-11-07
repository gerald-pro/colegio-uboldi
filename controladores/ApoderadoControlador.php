<?php

class ApoderadoControlador
{

    /*=============================================
    REGISTRO DE APODERADO
    =============================================*/

    static public function crear()
    {
        if (isset($_POST["NuevoNombre"])) {
            $errores = [];

            // Validar cada campo y almacenar mensajes de error personalizados si no es válido
            $nombreValidation = Validador::validarNombre($_POST["NuevoNombre"], "El nombre");
            if (!$nombreValidation["valido"]) {
                $errores["nombre"] = $nombreValidation["mensaje"];
            }

            $apellidoValidation = Validador::validarNombre($_POST["NuevoApellido"], "El apellido");
            if (!$apellidoValidation["valido"]) {
                $errores["apellido"] = $apellidoValidation["mensaje"];
            }

            $direccionValidation = Validador::validarNoVacio($_POST["NuevaDireccion"], "La dirección");
            if (!$direccionValidation["valido"]) {
                $errores["direccion"] = $direccionValidation["mensaje"];
            }

            $telefonoValidation = Validador::validarSoloNumeros($_POST["NuevoTelefono"], "El teléfono");
            if (!$telefonoValidation["valido"]) {
                $errores["telefono"] = $telefonoValidation["mensaje"];
            }

            // Verificar si hay errores
            if (empty($errores)) {
                $datos = array(
                    "nombre" => $_POST["NuevoNombre"],
                    "apellido" => $_POST["NuevoApellido"],
                    "direccion" => $_POST["NuevaDireccion"],
                    "telefono" => $_POST["NuevoTelefono"],
                    "id_usuario" => $_POST["NuevoIdUsuario"]
                );

                $respuesta = Apoderado::crear($datos);

                if ($respuesta == "ok") {
                    echo Mensaje::obtenerMensaje(
                        "success",
                        "El apoderado ha sido registrado correctamente",
                        null,
                        "apoderados"
                    );
                } else {
                    echo Mensaje::obtenerMensaje(
                        "error",
                        "Ocurrió un error al registrar el apoderado",
                        $respuesta,
                        "apoderados"
                    );
                }
            } else {
                // Mostrar errores en un mensaje detallado
                echo Mensaje::obtenerMensaje(
                    "error",
                    "Errores de validación",
                    "Errores: " . implode(", ", $errores),
                    "apoderados"
                );
            }
        }
    }

    /*=============================================
    MOSTRAR APODERADO
    =============================================*/

    static public function listar($item = null, $valor = null)
    {
        $respuesta = Apoderado::listar($item, $valor);

        return $respuesta;
    }

    /*=============================================
    EDITAR APODERADO
    =============================================*/

    static public function editar()
    {

        if (isset($_POST["EditarNombre"])) {

            $errores = [];

            // Validar cada campo y almacenar mensajes de error personalizados si no es válido
            $nombreValidation = Validador::validarNombre($_POST["EditarNombre"], "El nombre");
            if (!$nombreValidation["valido"]) {
                $errores["nombre"] = $nombreValidation["mensaje"];
            }

            $apellidoValidation = Validador::validarNombre($_POST["EditarApellido"], "El apellido");
            if (!$apellidoValidation["valido"]) {
                $errores["apellido"] = $apellidoValidation["mensaje"];
            }

            $direccionValidation = Validador::validarNoVacio($_POST["EditarDireccion"], "La dirección");
            if (!$direccionValidation["valido"]) {
                $errores["direccion"] = $direccionValidation["mensaje"];
            }

            $telefonoValidation = Validador::validarSoloNumeros($_POST["EditarTelefono"], "El teléfono");
            if (!$telefonoValidation["valido"]) {
                $errores["telefono"] = $telefonoValidation["mensaje"];
            }

            $usuarioIdValidation = Validador::validarSoloNumeros($_POST["EditarIdUsuario"], "El ID de usuario");
            if (!$usuarioIdValidation["valido"]) {
                $errores["id_usuario"] = $usuarioIdValidation["mensaje"];
            }

            // Verificar si hay errores
            if (empty($errores)) {
                $datos = array(
                    "nombre" => $_POST["EditarNombre"],
                    "apellido" => $_POST["EditarApellido"],
                    "direccion" => $_POST["EditarDireccion"],
                    "telefono" => $_POST["EditarTelefono"],
                    "id_usuario" => $_POST["EditarIdUsuario"],
                    "id" => $_POST["IdApoderado"]
                );

                $respuesta = Apoderado::editar($datos);

                if ($respuesta == "ok") {
                    echo '<script>
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
                } else {
                    echo '<script>
                        swal({
                            type: "error",
                            title: "¡Ocurrió un error al editar el apoderado!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "apoderados";
                            }
                        })
                    </script>';
                }
            } else {
                // Mostrar errores en un mensaje detallado si hay problemas de validación
                echo '<script>
                    swal({
                        type: "error",
                        title: "Errores de validación",
                        text: "Errores: ' . implode(", ", $errores) . '",
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

    static public function eliminar()
    {

        if (isset($_GET["id"])) {
            $datos = $_GET["id"];

            $respuesta = Apoderado::eliminar($datos);

            if ($respuesta == "ok") {

                echo '<script>

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
