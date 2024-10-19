<?php

require_once "../controladores/DetalleCuotasControlador.php";
require_once "../modelos/DetalleCuota.php";

class AjaxDetalleCuotas {

    /*=============================================
    EDITAR DETALLE DE CUOTA
    =============================================*/

    public $id;

    public function ajaxEditarDetalleCuota(){

        $item = "id";
        $valor = $this->id;

        $respuesta = DetalleCuotasControlador::listar($item, $valor);

        echo json_encode($respuesta);

    }
}

/*=============================================
EDITAR DETALLE DE CUOTA
=============================================*/
if(isset($_POST["id"])){

    $detalleCuotas = new AjaxDetalleCuotas();
    $detalleCuotas->id = $_POST["id"];
    $detalleCuotas->ajaxEditarDetalleCuota();
}
?>
