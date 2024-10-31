<?php

require_once "../controladores/CuotaControlador.php";
require_once "../modelos/Cuota.php";

class AjaxCuotas
{
    public $id;
    public $idEstudiante;

    public function ajaxEditarCuota()
    {
        $item = "id";
        $valor = $this->id;

        $respuesta = Cuota::listar($item, $valor);
        if ($respuesta) {
            $fecha = date_create($respuesta['fecha_vencimiento']);
            $respuesta['fecha_vencimiento'] = date_format($fecha, "Y-m-d");
            echo json_encode($respuesta);
        } else {
            echo json_encode(["error" => "Cuota no encontrada"]);
        }
    }

    public function ajaxListarCuotasPendientes()
    {
        $idEstudiante = $this->idEstudiante;
        $respuesta = Cuota::listarCuotasPendientesPorEstudiante($idEstudiante);

        echo json_encode($respuesta);
    }
}


if (isset($_POST["id"])) {
    $cuota = new AjaxCuotas();
    $cuota->id = $_POST["id"];
    $cuota->ajaxEditarCuota();
}

if (isset($_POST["idEstudiante"])) {
    $cuotas = new AjaxCuotas();
    $cuotas->idEstudiante = $_POST["idEstudiante"];
    $cuotas->ajaxListarCuotasPendientes();
}