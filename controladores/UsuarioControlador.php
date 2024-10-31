<?php

class UsuarioControlador
{

	/*=============================================
		  INGRESO DE USUARIO
		  =============================================*/

	static public function ctrIngresoUsuario()
	{
		if (isset($_POST["ingUsuario"])) {

			if (
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])
			) {

				//$encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
				$encriptar = $_POST["ingPassword"];
				$tabla = "usuarios";

				$item = "usuario";
				$valor = $_POST["ingUsuario"];

				$respuesta = Usuario::listar($item, $valor);

				if ($respuesta["usuario"] == $_POST["ingUsuario"] && $respuesta["password"] == $encriptar) {
					$_SESSION["iniciarSesion"] = "ok";
					$_SESSION["id"] = $respuesta["id"];
					$_SESSION["correo"] = $respuesta["correo"];
					$_SESSION["fecha_registro"] = $respuesta["fecha_registro"];
					$_SESSION["usuario"] = $respuesta["usuario"];

					/*=============================================
													 REGISTRAR FECHA PARA SABER EL ÚLTIMO LOGIN
													 =============================================*/

					date_default_timezone_set('America/Bogota');

					$fecha = date('Y-m-d');
					$hora = date('H:i:s');

					$fechaActual = $fecha . ' ' . $hora;

					$item1 = "fecha";
					$valor1 = $fechaActual;

					$item2 = "id";
					$valor2 = $respuesta["id"];

					$ultimoLogin = Usuario::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

					if ($ultimoLogin == "ok") {

						echo '<script>

								window.location = "inicio";

							</script>';
					}
				} else {
					echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';
				}
			}
		}
	}

	/*=============================================
		  REGISTRO DE USUARIO
		  =============================================*/

	static public function ctrCrearUsuario()
	{
		if (isset($_POST["NuevoUsuario"])) {

			if (
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["NuevoUsuario"]) &&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["NuevaPassword"])
			) {


				$tabla = "usuarios";

				//$encriptar = crypt($_POST["NuevaPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$datos = array(
					"usuario" => $_POST["NuevoUsuario"],
					"correo" => $_POST["NuevoCorreo"],
					"fecha_registro" => $_POST["NuevaFecha"],
					"password" => $_POST["NuevaPassword"],
				);
				var_dump($datos);


				$respuesta = Usuario::mdlIngresarUsuario($tabla, $datos);

				if ($respuesta == "ok") {

					echo '<script>

                    swal({
                          type: "success",
                          title: "El usuario a sido guardado correctamente",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                                    if (result.value) {

                                    window.location = "usuarios";

                                    }
                                })

                    </script>';
				}
			} else {

				echo '<script>

                    swal({
                          type: "error",
                          title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                            if (result.value) {

                            window.location = "usuario";

                            }
                        })

                  </script>';
			}
		}
	}

	/*=============================================
		  MOSTRAR USUARIO
		  =============================================*/

	static public function listar($item, $valor)
	{
		$respuesta = Usuario::listar($item, $valor);

		return $respuesta;
	}

	/*=============================================
		  EDITAR USUARIO
		  =============================================*/

	static public function ctrEditarUsuario()
	{

		if (isset($_POST["EditarUsuario"])) {

			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["EditarUsuario"])) {


				$tabla = "usuarios";


				$datos = array(
					"usuario" => $_POST["EditarUsuario"],
					"correo" => $_POST["EditarCorreo"],
					"fecha_registro" => $_POST["EditarFecha"],
				);

				$respuesta = Usuario::mdlEditarUsuario($tabla, $datos);

				if ($respuesta == "ok") {
					echo '<script>
					swal({
						  type: "success",
						  title: "El usuario ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "usuarios";
									}
								})
					</script>';
				}
				else {
					echo '<script>
					swal({
						  type: "success",
						  title: "' . $respuesta . '",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "usuarios";
									}
								})
					</script>';
				}
			} else {

				echo '<script>

					swal({
						  type: "error",
						  title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "usuarios";

							}
						})

			  	</script>';
			}
		}
	}

	/*=============================================
		  BORRAR USUARIO
		  =============================================*/

	static public function ctrBorrarUsuario()
	{

		if (isset($_GET["id"])) {

			$tabla = "usuarios";
			$datos = $_GET["id"];

			$respuesta = Usuario::mdlBorrarUsuario($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>

				swal({
					  type: "success",
					  title: "El usuario ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "usuarios";

								}
							})

				</script>';
			}
		}
	}
}
