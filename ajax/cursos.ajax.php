<?php
require_once "../controladores/CursoControlador.php";
require_once "../modelos/Curso.php";

class AjaxCursos{

	/*=============================================
	EDITAR CURSO
	=============================================*/	

	public $id;

	public function ajaxEditarCurso(){

		$item = "id";
		$valor = $this->id;

		$respuesta = CursoControlador::listar($item, $valor);
		if ($respuesta) {
			echo json_encode($respuesta);
		} else {
			echo json_encode(["error" => "Curso no encontrado"]);
		}
	}	
}

/*=============================================
EDITAR CURSO
=============================================*/
if(isset($_POST["id"])){
	$editar = new AjaxCursos();
	$editar -> id = $_POST["id"];
	$editar -> ajaxEditarCurso();
}
