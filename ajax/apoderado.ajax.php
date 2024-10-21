<?php

require_once "../controladores/ApoderadoControlador.php";
require_once "../modelos/Apoderado.php";

class AjaxApoderado
{

    /*=============================================
    EDITAR APODERADO
    =============================================*/

    public $id;
    public $idEstudiante;

    public function ajaxEditarApoderado()
    {
        $item = "id";
        $valor = $this->id;

        $respuesta = ApoderadoControlador::listar($item, $valor);

        echo json_encode($respuesta);
    }

    public function ajaxObtenerApoderado()
    {
        $respuesta = Apoderado::buscarPorEstudiante($this->idEstudiante);
        echo json_encode([
            'nombre' => $respuesta['nombre'],
            'apellido' => $respuesta['apellido']
        ]);
    }
}

/*=============================================
EDITAR APODERADO
=============================================*/
if (isset($_POST["id"])) {

    $apoderado = new AjaxApoderado();
    $apoderado->id = $_POST["id"];
    $apoderado->ajaxEditarApoderado();
}

if (isset($_POST["idEstudiante"])) {
    $apoderado = new AjaxApoderado();
    $apoderado->idEstudiante = $_POST["idEstudiante"];
    $apoderado->ajaxObtenerApoderado();
}
