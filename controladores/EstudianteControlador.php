<?php

require_once 'Validador.php';
require_once 'Mensajes.php';

class EstudianteControlador
{
    static public function crear()
    {
        if (isset($_POST["nuevoNombre"])) {
            if (
                Validador::validarNombre($_POST["nuevoNombre"])  &&
                Validador::validarNombre($_POST["nuevoApellido"]) &&
                Validador::validarSoloNumeros($_POST["nuevoTelefono"]) &&
                Validador::validarSoloNumeros($_POST["nuevoIdCurso"]) &&
                Validador::validarSoloNumeros($_POST["nuevoIdApoderado"]) &&
                Validador::validarFecha($_POST["nuevaFechaNac"])
            ) {
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
                    $mensaje =  Mensaje::obtenerMensaje(
                        "success",
                        "El estudiante ha sido registrado correctamente",
                        null,
                        "estudiantes"
                    );
                } else {
                    $mensaje = Mensaje::obtenerMensaje(
                        "error",
                        "Ocurrió un error",
                        $respuesta,
                        "estudiantes"
                    );
                }
                echo $mensaje;
            } else {
                $mensaje = Mensaje::obtenerMensaje(
                    "error",
                    "Entrada incorrecta",
                    "¡Los campos no pueden ir vacíos y deben contener solo letras (nombre, apellido y dirección) o números (teléfono)!",
                    "estudiantes"
                );

                echo $mensaje;
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
            if (
                Validador::validarNombre($_POST["editarNombre"])  &&
                Validador::validarNombre($_POST["editarApellido"]) &&
                Validador::validarSoloNumeros($_POST["editarTelefono"])
            ) {
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

                $respuesta = Estudiante::editar('estudiantes', $datos);

                if ($respuesta == "ok") {
                    $mensaje =  Mensaje::obtenerMensaje(
                        "success",
                        "El estudiante ha sido editado correctamente",
                        null,
                        "estudiantes"
                    );
                } else {
                    $mensaje = Mensaje::obtenerMensaje(
                        "error",
                        "Ocurrió un error",
                        $respuesta,
                        "estudiantes"
                    );
                }
                echo $mensaje;
            } else {
                $mensaje = Mensaje::obtenerMensaje(
                    "error",
                    "Entrada incorrecta",
                    "¡Los campos no pueden ir vacíos y deben contener solo letras (nombre, apellido y dirección) o números (teléfono)!",
                    "estudiantes"
                );

                echo $mensaje;
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
