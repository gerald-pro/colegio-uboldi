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
				isset($_POST["nuevoIdCuotas"]) && is_array($_POST["nuevoIdCuotas"])
			) {
				$apoderado = Apoderado::buscarPorEstudiante($_POST['nuevoIdEstudiante']);
				$estudiante = Estudiante::listar('id', $_POST['nuevoIdEstudiante']);
				$curso = Curso::buscarPorId($estudiante['id_curso']);

				$datosPago  = array(
					"codigo" => $_POST["nuevoCpago"],
					"monto_total" => $_POST["nuevoMonto"],
					"id_estudiante" => $_POST['nuevoIdEstudiante'],
					"id_apoderado" => $apoderado['id'],
					"id_curso" => $curso['id'],
					"id_metodo_pago" => $_POST['nuevoIdMetodo'],
				);

				$response = Pago::crear($datosPago);

				if (is_numeric($response)) {
					foreach ($_POST["nuevoIdCuotas"] as $idCuota) {
						$cuota = Cuota::listar('id', $idCuota);
						$respuestaDetalle = DetallePago::crear($response, $idCuota, $cuota['monto']);

						if ($respuestaDetalle != "ok") {
							echo Mensaje::obtenerMensaje(
								"error",
								"Ocurrió un error en el registro de los detalles de pago",
								$respuestaDetalle,
								"pagos"
							);
							return;
						}
					}

					$mensaje =  Mensaje::obtenerMensaje(
						"success",
						"El pago ha sido registrado correctamente",
						null,
						"pagos"
					);
				} else {
					if ($response[0] == 23000) {
						$response[2] = "El código de pago ya existe en la base de datos";
					}

					$mensaje = Mensaje::obtenerMensaje(
						"error",
						"Ocurrió un error",
						$response[2],
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
