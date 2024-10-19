<?php
class PagoControlador
{
	/*=============================================
    REGISTRO DE PAGO
    =============================================*/
	static public function crear()
	{
		if (isset($_POST["nuevoMonto"]) && isset($_POST["nuevoIdApoderado"])) {
			if (
				preg_match('/^[0-9]+$/', $_POST["nuevoCpago"]) &&
				preg_match('/^[0-9]+$/', $_POST["nuevoMonto"]) &&

				preg_match('/^[0-9]+$/', $_POST["nuevoIdEstudiante"]) &&
				preg_match('/^[0-9]+$/', $_POST["nuevoIdApoderado"]) &&
				preg_match('/^[0-9]+$/', $_POST["nuevoIdCurso"])

			) {
				$datos = array(
					"codigo" => $_POST["nuevoCpago"],
					"monto" => $_POST["nuevoMonto"],
					"gestion" => $_POST["nuevoGestion"],
					"id_estudiante" => $_POST['nuevoIdEstudiante'],
					"id_apoderado" => $_POST['nuevoIdApoderado'],
					"id_curso" => $_POST['nuevoIdCurso'],
					"id_metodo_pago" => $_POST['nuevoIdMetodo'],
				);

				$respuesta = Pago::crear($datos);

				if ($respuesta == "ok") {
					echo '<script>
                    swal({
                          type: "success",
                          title: "El pago ha sido registrado correctamente",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                                    if (result.value) {
                                    window.location = "pagos";
                                    }
                                })

                    </script>';
				}
			} else {
				echo '<script>

                    swal({
                          type: "error",
                          title: "¡Los campos no pueden ir vacíos y deben contener los formatos correctos!",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                            if (result.value) {
                            window.location = "pagos";
                            }
                    
                  </script>';
			}
		}
	}

	/*=============================================
    MOSTRAR PAGOS
    =============================================*/
	static public function listar()
	{
		$respuesta = Pago::listar();
		return $respuesta;
	}

	/*=============================================
    EDITAR PAGO
    =============================================*/

	static public function editar()
	{
		if (isset($_POST["editarMonto"])) {
			if (
				preg_match('/^[0-9]+$/', $_POST["editarCodigo"]) &&
				preg_match('/^[0-9]+$/', $_POST["editarMonto"]) &&

				preg_match('/^[0-9]+$/', $_POST["editarIdEstudiante"]) &&
				preg_match('/^[0-9]+$/', $_POST["editarIdApoderado"]) &&
				preg_match('/^[0-9]+$/', $_POST["editarIdCurso"])

			) {

				$datos = array(
					"codigo" => $_POST["editarCodigo"],
					"monto" => $_POST["editarMonto"],

					"id_estudiante" => $_POST["editarIdEstudiante"],
					"id_apoderado" => $_POST["editarIdApoderado"],
					"id_curso" => $_POST["editarIdCurso"],

					"id" => $_POST["idPago"]
				);

				$respuesta = Pago::editar($datos);

				if ($respuesta == "ok") {
					echo '<script>
                    swal({
                          type: "success",
                          title: "El pago ha sido editado correctamente",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                                    if (result.value) {
                                    window.location = "pagos";
                                    }
                                })
                    </script>';
				}
			} else {
				echo '<script>
                    swal({
                          type: "error",
                          title: "¡Los campos no pueden ir vacíos y deben contener los formatos correctos!",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                            if (result.value) {
                            window.location = "pagos";
                            }
                        })

                  </script>';
			}
		}
	}

	/*=============================================
    ELIMINAR PAGO
    =============================================*/
	static public function eliminar()
	{
		if (isset($_GET["id"])) {
			$datos = $_GET["id"];
			$respuesta = Pago::eliminar($datos);

			if ($respuesta == "ok") {
				echo '<script>
                swal({
                      type: "success",
                      title: "El pago ha sido borrado correctamente",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar"
                      }).then(function(result){
                                if (result.value) {

                                window.location = "pagos";
                                }
                            })
                </script>';
			}
		}
	}
}
