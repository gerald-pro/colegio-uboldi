<?php

require_once "../controladores/PagoControlador.php";
require_once "../modelos/Pago.php";
require_once "../modelos/Cuota.php";
require_once "../modelos/Curso.php";

class AjaxPagos
{
    public $id;

	public function ajaxEditarPago()
	{
		$item = "id";
		$valor = $this->id;

		$respuesta = Pago::listar($item, $valor);
		if ($respuesta) {
			$curso = Curso::buscarPorId($respuesta['id_curso']);
			$cuotas = Cuota::listarCuotasPorPago($valor);
			$fecha = date_create($respuesta['fecha']);

			$respuesta['fecha'] = date_format($fecha, "Y-m-d");
			$respuesta['hora'] = date_format($fecha, "H:i");
			$respuesta['detalle_cuotas'] = $cuotas;
			$respuesta['curso'] = $curso;

			echo json_encode($respuesta);
		} else {
			echo json_encode(["error" => "Pago no encontrado"]);
		}
	}
}

/*=============================================
EDITAR ESTUDIANTE
=============================================*/
if(isset($_POST["id"])){
    $pago = new AjaxPagos();
    $pago -> id = $_POST["id"];
    $pago -> ajaxEditarPago();
}