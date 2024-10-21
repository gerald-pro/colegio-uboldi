<?php

class CuotaControlador
{
    static public function crear()
    {
        if (isset($_POST["nuevaGestion"]) && isset($_POST["nuevoMes"]) && isset($_POST["nuevoMonto"])) {
            if (
                Validador::validarSoloNumeros($_POST["nuevaGestion"]) &&
                Validador::validarSoloNumeros($_POST["nuevoMes"]) &&
                Validador::validarSoloNumeros($_POST["nuevoMonto"]) &&
                Validador::validarFecha($_POST["nuevaFechaVencimiento"])
            ) {
                $datos = array(
                    "gestion" => $_POST["nuevaGestion"],
                    "mes" => $_POST["nuevoMes"],
                    "monto" => $_POST["nuevoMonto"],
                    "fecha_vencimiento" => $_POST["nuevaFechaVencimiento"]
                );

                $respuesta = Cuota::crear($datos);

                if ($respuesta == "ok") {
                    $mensaje = Mensaje::obtenerMensaje(
                        "success",
                        "La cuota ha sido registrada correctamente",
                        null,
                        "cuotas"
                    );
                } else {
                    $mensaje = Mensaje::obtenerMensaje(
                        "error",
                        "Ocurrió un error",
                        $respuesta,
                        "cuotas"
                    );
                }
                echo $mensaje;
            } else {
                $mensaje = Mensaje::obtenerMensaje(
                    "error",
                    "Entrada incorrecta",
                    "¡Los campos no pueden ir vacíos y deben contener los formatos correctos!",
                    "cuotas"
                );
                echo $mensaje;
            }
        }
    }

    static public function listar()
    {
        $respuesta = Cuota::listar();
        return $respuesta;
    }

    static public function editar()
    {
        if (isset($_POST["editarId"]) && isset($_POST["editarGestion"]) && isset($_POST["editarMes"])) {
            if (
                Validador::validarSoloNumeros($_POST["editarGestion"]) &&
                Validador::validarSoloNumeros($_POST["editarMes"]) &&
                Validador::validarFlotante($_POST["editarMonto"]) &&
                Validador::validarFecha($_POST["editarFechaVencimiento"])
            ) {
                $datos = array(
                    "id" => $_POST["editarId"],
                    "gestion" => $_POST["editarGestion"],
                    "mes" => $_POST["editarMes"],
                    "monto" => $_POST["editarMonto"],
                    "fecha_vencimiento" => $_POST["editarFechaVencimiento"]
                );

                $respuesta = Cuota::editar($datos);

                if ($respuesta == "ok") {
                    $mensaje = Mensaje::obtenerMensaje(
                        "success",
                        "La cuota ha sido editada correctamente",
                        null,
                        "cuotas"
                    );
                } else {
                    $mensaje = Mensaje::obtenerMensaje(
                        "error",
                        "Ocurrió un error",
                        $respuesta,
                        "cuotas"
                    );
                }
                echo $mensaje;
            } else {
                $mensaje = Mensaje::obtenerMensaje(
                    "error",
                    "Entrada incorrecta",
                    "¡Los campos no pueden ir vacíos y deben contener los formatos correctos!",
                    "cuotas"
                );
                echo $mensaje;
            }
        }
    }

    static public function eliminar()
    {
        if (isset($_GET["id"])) {
            $datos = $_GET["id"];
            $respuesta = Cuota::eliminar($datos);

            if ($respuesta == "ok") {
                $mensaje = Mensaje::obtenerMensaje(
                    "success",
                    "La cuota ha sido eliminada correctamente",
                    null,
                    "cuotas"
                );
                echo $mensaje;
            }
        }
    }
}
