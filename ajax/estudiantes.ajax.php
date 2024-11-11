<?php

require_once "../controladores/EstudianteControlador.php";
require_once "../modelos/Estudiante.php";
require_once "../modelos/Apoderado.php";

class AjaxEstudiante{

    /*=============================================
    EDITAR ESTUDIANTE
    =============================================*/

    public $id;

    public function ajaxEditarEstudiante(){
        $item = "id";
        $valor = $this->id;
        $respuesta = Estudiante::listar($item, $valor);
        $respuesta['apoderado'] = Apoderado::buscarPorId($respuesta['id_apoderado'])['nombre']; 
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
