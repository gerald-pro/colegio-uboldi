<?php

require_once 'Validador.php';
require_once 'Mensajes.php';

class EstudianteControlador
{
    static public function crear()
    {
        if (isset($_POST["nuevoNombre"])) {
            $errores = [];

            // Validar cada campo y almacenar mensajes de error personalizados si no es válido
            $nombreValidation = Validador::validarNombre($_POST["nuevoNombre"], "El nombre");
            if (!$nombreValidation["valido"]) {
                $errores["nombre"] = $nombreValidation["mensaje"];
            }

            $apellidoValidation = Validador::validarNombre($_POST["nuevoApellido"], "El apellido");
            if (!$apellidoValidation["valido"]) {
                $errores["apellido"] = $apellidoValidation["mensaje"];
            }

            $telefonoValidation = Validador::validarSoloNumeros($_POST["nuevoTelefono"], "El teléfono");
            if (!$telefonoValidation["valido"]) {
                $errores["telefono"] = $telefonoValidation["mensaje"];
            }

            $cursoValidation = Validador::validarSoloNumeros($_POST["nuevoIdCurso"], "El ID de curso");
            if (!$cursoValidation["valido"]) {
                $errores["id_curso"] = $cursoValidation["mensaje"];
            }

            $apoderadoValidation = Validador::validarSoloNumeros($_POST["nuevoIdApoderado"], "El ID de apoderado");
            if (!$apoderadoValidation["valido"]) {
                $errores["id_apoderado"] = $apoderadoValidation["mensaje"];
            }

            $fechaNacValidation = Validador::validarFecha($_POST["nuevaFechaNac"], "La fecha de nacimiento");
            if (!$fechaNacValidation["valido"]) {
                $errores["fecha_nacimiento"] = $fechaNacValidation["mensaje"];
            }

            // Verificar si hay errores
            if (empty($errores)) {
                $usuario = Estudiante::listar('correo', $_POST["nuevoCorreo"]);
                $error = null;

                if ($usuario) {
                    $error = "El correo ya ha sido registrado por otro estudiante";
                }

                if ($error) {
                    echo Mensaje::obtenerMensaje(
                        "error",
                        "Ocurrió un error",
                        $error,
                        "estudiantes"
                    );
                } else {
                    $datos = array(
                        "nombre" => $_POST["nuevoNombre"],
                        "apellidos" => $_POST["nuevoApellido"],
                        "direccion" => $_POST["nuevaDireccion"],
                        "fecha_nacimiento" => $_POST["nuevaFechaNac"],
                        "correo" => $_POST["nuevoCorreo"],
                        "telefono" => $_POST["nuevoTelefono"],
                        "id_curso" => $_POST['nuevoIdCurso'],
                        "id_apoderado" => $_POST['nuevoIdApoderado']
                    );

                    $respuesta = Estudiante::crear($datos);

                    if ($respuesta == "ok") {
                        echo Mensaje::obtenerMensaje(
                            "success",
                            "El estudiante ha sido registrado correctamente",
                            null,
                            "estudiantes"
                        );
                    } else {
                        echo Mensaje::obtenerMensaje(
                            "error",
                            "Ocurrió un error",
                            $respuesta,
                            "estudiantes"
                        );
                    }
                }
            } else {
                // Mostrar errores en un mensaje detallado si hay problemas de validación
                echo Mensaje::obtenerMensaje(
                    "error",
                    "Errores de validación",
                    "Errores: " . implode(", ", $errores),
                    "estudiantes"
                );
            }
        }
    }

    static public function listar()
    {
        $respuesta = Estudiante::listar();
        return $respuesta;
    }

    static public function editar()
    {
        if (isset($_POST["editarNombre"])) {
            $errores = [];

            // Validar cada campo y almacenar mensajes de error personalizados si no es válido
            $nombreValidation = Validador::validarNombre($_POST["editarNombre"], "El nombre");
            if (!$nombreValidation["valido"]) {
                $errores["nombre"] = $nombreValidation["mensaje"];
            }

            $apellidoValidation = Validador::validarNombre($_POST["editarApellido"], "El apellido");
            if (!$apellidoValidation["valido"]) {
                $errores["apellido"] = $apellidoValidation["mensaje"];
            }

            $telefonoValidation = Validador::validarSoloNumeros($_POST["editarTelefono"], "El teléfono");
            if (!$telefonoValidation["valido"]) {
                $errores["telefono"] = $telefonoValidation["mensaje"];
            }

            $cursoValidation = Validador::validarSoloNumeros($_POST["editarIdCurso"], "El ID de curso");
            if (!$cursoValidation["valido"]) {
                $errores["id_curso"] = $cursoValidation["mensaje"];
            }

            $apoderadoValidation = Validador::validarSoloNumeros($_POST["editarIdApoderado"], "El ID de apoderado");
            if (!$apoderadoValidation["valido"]) {
                $errores["id_apoderado"] = $apoderadoValidation["mensaje"];
            }

            $fechaNacValidation = Validador::validarFecha($_POST["editarFechaNac"], "La fecha de nacimiento");
            if (!$fechaNacValidation["valido"]) {
                $errores["fecha_nacimiento"] = $fechaNacValidation["mensaje"];
            }

            // Verificar si hay errores
            if (empty($errores)) {
                $datos = array(
                    "nombre" => $_POST["editarNombre"],
                    "apellidos" => $_POST["editarApellido"],
                    "direccion" => $_POST["editarDireccion"],
                    "fecha_nacimiento" => $_POST["editarFechaNac"],
                    "correo" => $_POST["editarCorreo"],
                    "telefono" => $_POST["editarTelefono"],
                    "id_curso" => $_POST["editarIdCurso"],
                    "id_apoderado" => $_POST["editarIdApoderado"],
                    "id" => $_POST["idEstudiante"]
                );

                $respuesta = Estudiante::editar($datos);

                if ($respuesta == "ok") {
                    echo Mensaje::obtenerMensaje(
                        "success",
                        "El estudiante ha sido editado correctamente",
                        null,
                        "estudiantes"
                    );
                } else {
                    echo Mensaje::obtenerMensaje(
                        "error",
                        "Ocurrió un error",
                        $respuesta,
                        "estudiantes"
                    );
                }
            } else {
                // Mostrar errores en un mensaje detallado si hay problemas de validación
                echo Mensaje::obtenerMensaje(
                    "error",
                    "Errores de validación",
                    "Errores: " . implode(", ", $errores),
                    "estudiantes"
                );
            }
        }
    }

    static public function eliminar()
    {
        if (isset($_GET["id"])) {
            $datos = $_GET["id"];
            $respuesta = Estudiante::eliminar('estudiantes', $datos);

            if ($respuesta == "ok") {
                $mensaje =  Mensaje::obtenerMensaje(
                    "success",
                    "El estudiante ha sido borrado correctamente",
                    null,
                    "estudiantes"
                );

                echo $mensaje;
            }
        }
    }
}
