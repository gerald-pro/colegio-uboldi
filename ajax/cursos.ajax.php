<?php
require_once "../controladores/CursoControlador.php";
require_once "../modelos/Curso.php";
require_once "../modelos/Estudiante.php";

class AjaxCursos{

	/*=============================================
	EDITAR CURSO
	=============================================*/	

	public $id;
	public $idEstudiante;
	
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

	public function ajaxObtenerCursoPorEstudiante() {
        $item = "id";
        $valor = $this->idEstudiante;

        // Obtener el estudiante por ID
        $estudiante = Estudiante::listar($item, $valor); // Método que debes tener en el modelo Estudiante

        if ($estudiante) {
            $idCurso = $estudiante["id_curso"];

            // Obtener el curso por ID
            $curso = Curso::listar("id", $idCurso); // Método que debes tener en el modelo Curso

            if ($curso) {
                echo json_encode(['nombre' => $curso['nombre'] . $curso['paralelo']]);
            } else {
                echo json_encode(["error" => "Curso no encontrado"]);
            }
        } else {
            echo json_encode(["error" => "Estudiante no encontrado"]);
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


if (isset($_POST["idEstudiante"])) {
    $cursoAjax = new AjaxCursos();
    $cursoAjax->idEstudiante = $_POST["idEstudiante"];
    $cursoAjax->ajaxObtenerCursoPorEstudiante();
}