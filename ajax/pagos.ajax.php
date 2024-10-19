<?php

require_once "../controladores/PagoControlador.php";
require_once "../modelos/Pago.php";

class AjaxPagos
{
    public $id;

	public function ajaxEditarPago()
	{
		$item = "id";
		$valor = $this->id;

		$respuesta = Pago::listar($item, $valor);
		if ($respuesta) {
			$fecha = date_create($respuesta['fecha']);
			$hora = date_create($respuesta['hora']);
			$respuesta['fecha'] = date_format($fecha, "Y-m-d");
			$respuesta['hora'] = date_format($fecha, "H:i");
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