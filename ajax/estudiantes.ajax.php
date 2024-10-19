<?php

require_once "../controladores/EstudianteControlador.php";
require_once "../modelos/Estudiante.php";

class AjaxEstudiante{

    /*=============================================
    EDITAR ESTUDIANTE
    =============================================*/

    public $id;

    public function ajaxEditarEstudiante(){
        $item = "id";
        $valor = $this->id;
        $respuesta = Estudiante::listar($item, $valor);
        echo json_encode($respuesta);
    }
}

/*=============================================
EDITAR ESTUDIANTE
=============================================*/
if(isset($_POST["id"])){
    $estudiante = new AjaxEstudiante();
    $estudiante -> id = $_POST["id"];
    $estudiante -> ajaxEditarEstudiante();
}
