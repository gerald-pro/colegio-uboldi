<?php

class CursoControlador
{
	/*=============================================
	REGISTRO DE CURSO
	=============================================*/
	static public function crear()
	{
		if (isset($_POST["nuevoCurso"])) {
			if (
				preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["nuevoCurso"]) &&
				preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["nuevoParalelo"])
			) {

				$tabla = "cursos";

				$datos = array(
					"nombre" => $_POST["nuevoCurso"],
					"paralelo" => $_POST["nuevoParalelo"]
				);

				$respuesta = Curso::crear($tabla, $datos);

				if ($respuesta == "ok") {
					echo '<script>
                    swal({
                          type: "success",
                          title: "El curso ha sido guardado correctamente",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                                    if (result.value) {

                                    window.location = "cursos";

                                    }
                                })

                    </script>';
				}
			} else {

				echo '<script>

                    swal({
                          type: "error",
                          title: "¡El curso no puede ir vacío o llevar caracteres especiales!",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                            if (result.value) {

                            window.location = "cursos";

                            }
                        })

                  </script>';
			}
		}
	}

	/*=============================================
	MOSTRAR CURSO
	=============================================*/

	static public function listar($item = null, $valor = null)
	{
		$respuesta = Curso::listar($item, $valor);

		return $respuesta;
	}

	/*=============================================
	EDITAR CURSO
	=============================================*/

	static public function editar()
	{
		if (isset($_POST["editarCurso"])) {
			if (
				preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["editarCurso"]) &&
				preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["editarParalelo"])
			) {
				$datos = array(
					"id" => $_POST["idCurso"],
					"nombre" => $_POST["editarCurso"],
					"paralelo" => $_POST["editarParalelo"]
				);

				$respuesta = Curso::editar($datos);

				if ($respuesta == "ok") {

					echo '<script>

					swal({
						  type: "success",
						  title: "El curso ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "cursos";
									}
								})

					</script>';
				}
			} else {

				echo '<script>

					swal({
						  type: "error",
						  title: "¡El curso no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "cursos";

							}
						})

			  	</script>';
			}
		}
	}

	/*=============================================
	BORRAR CURSO
	=============================================*/

	static public function eliminar()
	{
		if (isset($_GET["id"])) {
			$tabla = "cursos";
			$datos = $_GET["id"];
			$respuesta = Curso::eliminar($tabla, $datos);

			if ($respuesta == "ok") {
				echo '<script>
				swal({
					  type: "success",
					  title: "El curso ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "cursos";

								}
							})

				</script>';
			} else {
				echo '<script>

				swal({
					  type: "error",
					  title: "Error al eliminar el curso",
					  showConfirmButton: false,
					  }).then(function(result){
								if (result.value) {
								window.location = "cursos";
								}
							})

				</script>';
			}
		}
	}
}
