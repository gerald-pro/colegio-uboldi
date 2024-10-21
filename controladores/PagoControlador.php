<?php

require_once 'Validador.php';
require_once 'Mensajes.php';

class PagoControlador
{
	static public function crear()
	{
		if (isset($_POST["nuevoMonto"]) && isset($_POST["nuevoIdApoderado"])) {
			if (
				Validador::validarFlotante($_POST["nuevoMonto"]) &&
				Validador::validarSoloNumeros($_POST["nuevoIdEstudiante"]) &&
				Validador::validarSoloNumeros($_POST["nuevoIdMetodo"]) &&
				Validador::validarSoloNumeros($_POST["nuevoIdCuota"])
			) {

				$apoderado = Apoderado::buscarPorEstudiante($_POST['nuevoIdEstudiante']);
				$estudiante = Estudiante::listar('id', $_POST['nuevoIdEstudiante']);
				$curso = Curso::buscarPorId($estudiante['id_curso']);

				$datos = array(
					"codigo" => $_POST["nuevoCpago"],
					"monto" => $_POST["nuevoMonto"],
					"gestion" => $_POST["nuevoGestion"],
					"id_estudiante" => $_POST['nuevoIdEstudiante'],
					"id_apoderado" => $apoderado['id'],
					"id_curso" => $curso['id'],
					"id_metodo_pago" => $_POST['nuevoIdMetodo'],
					"id_cuota" => $_POST["nuevoIdCuota"]
				);

				$respuesta = Pago::crear($datos);

				if ($respuesta == "ok") {
					$mensaje =  Mensaje::obtenerMensaje(
						"success",
						"El pago ha sido registrado correctamente",
						null,
						"pagos"
					);
				} else {
					$mensaje = Mensaje::obtenerMensaje(
						"error",
						"Ocurrió un error",
						$respuesta,
						"pagos"
					);
				}
				echo $mensaje;
			} else {
				$mensaje = Mensaje::obtenerMensaje(
					"error",
					"Entrada incorrecta",
					"¡Los campos no pueden ir vacíos y deben contener los formatos correctos!",
					"estudiantes"
				);

				echo $mensaje;
			}
		}
	}

	static public function listar()
	{
		$respuesta = Pago::listar();
		return $respuesta;
	}

	static public function eliminar()
	{
		if (isset($_GET["id"])) {
			$datos = $_GET["id"];
			$respuesta = Pago::eliminar($datos);

			if ($respuesta == "ok") {
				$mensaje =  Mensaje::obtenerMensaje(
					"success",
					"El pago ha sido borrado correctamente",
					null,
					"pagos"
				);

				echo $mensaje;
			}
		}
	}
}
