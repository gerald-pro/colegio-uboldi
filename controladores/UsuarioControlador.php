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
				$rol = Usuario::obtenerRol($respuesta['id']);

				if ($respuesta["usuario"] == $_POST["ingUsuario"] && $respuesta["password"] == $encriptar) {
					$_SESSION["iniciarSesion"] = "ok";
					$_SESSION["id"] = $respuesta["id"];
					$_SESSION["correo"] = $respuesta["correo"];
					$_SESSION["fecha_registro"] = $respuesta["fecha_registro"];
					$_SESSION["usuario"] = $respuesta["usuario"];
					$_SESSION['rol'] = $rol;

					/*=============================================
													 REGISTRAR FECHA PARA SABER EL ÚLTIMO LOGIN
													 =============================================*/

					date_default_timezone_set('America/La_Paz');

					$fecha = date('Y-m-d');
					$hora = date('H:i:s');

					$fechaActual = $fecha . ' ' . $hora;

					$idUsuario = $respuesta["id"];
					$ultimoLogin = Usuario::mdlActualizarUsuario($idUsuario, $fechaActual);

					if ($ultimoLogin == "ok") {
						$redireccion = match ($rol) {
							'administradora' => 'usuarios',
							'contadora' => 'apoderados',
							'secretaria' => 'reportes', 
							default => 'inicio' 
						};

						echo '<script>
							window.location = "' . $redireccion . '";
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
			$errores = [];
			// Validar cada campo individualmente y almacenar mensajes de error si no es válido.
			$usernameValidation = Validador::validarUsername($_POST["NuevoUsuario"]);
			if (!$usernameValidation["valido"]) {
				$errores["usuario"] = $usernameValidation["mensaje"];
			}

			$passwordValidation = Validador::validarPassword($_POST["NuevaPassword"]);
			if (!$passwordValidation["valido"]) {
				$errores["password"] = $passwordValidation["mensaje"];
			}

			$correoValidation = Validador::validarCorreo($_POST["NuevoCorreo"]);
			if (!$correoValidation["valido"]) {
				$errores["correo"] = $correoValidation["mensaje"];
			}

			$fechaValidation = Validador::validarFecha($_POST["NuevaFecha"]);
			if (!$fechaValidation["valido"]) {
				$errores["fecha_registro"] = $fechaValidation["mensaje"];
			}

			// Verificar si hay errores.
			if (empty($errores)) {
				$usuario = Usuario::listar('usuario', $_POST["NuevoUsuario"]);
				$error = null;

				if ($usuario) {
					$error = "El nombre de usuario ya existe";
				}

				$usuario = Usuario::listar('correo', $_POST["NuevoCorreo"]);
				if ($usuario) {
					$error = "El correo ingresado ya se ha registrado";
				}

				if ($error) {
					echo Mensaje::obtenerMensaje(
						"error",
						"Ocurrió un error",
						$error,
						"usuarios"
					);
				} else {
					$datos = array(
						"usuario" => $_POST["NuevoUsuario"],
						"correo" => $_POST["NuevoCorreo"],
						"fecha_registro" => $_POST["NuevaFecha"],
						"password" => $_POST["NuevaPassword"],
						"id_rol" => $_POST["NuevoRol"],
					);

					$respuesta = Usuario::mdlIngresarUsuario($datos);

					if ($respuesta == "ok") {
						$mensaje = Mensaje::obtenerMensaje(
							"success",
							"El usuario ha sido guardado correctamente",
							null,
							"usuarios"
						);
					} else {
						$mensaje = Mensaje::obtenerMensaje(
							"error",
							"Ocurrió un error",
							$respuesta,
							"usuarios"
						);
					}
					echo $mensaje;
				}
			} else {
				// Si hay errores, mostrarlos en un mensaje de error.
				$mensaje = Mensaje::obtenerMensaje(
					"error",
					"Entrada incorrecta",
					"Errores: " . implode(", ", $errores),
					"usuarios"
				);
				echo $mensaje;
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
			$errores = [];

			// Validar cada campo individualmente y almacenar mensajes de error si no es válido.
			$correoValidation = Validador::validarCorreo($_POST["EditarCorreo"]);
			if (!$correoValidation["valido"]) {
				$errores["correo"] = $correoValidation["mensaje"];
			}

			$fechaValidation = Validador::validarFecha($_POST["EditarFecha"]);
			if (!$fechaValidation["valido"]) {
				$errores["fecha_registro"] = $fechaValidation["mensaje"];
			}

			// Verificar si hay errores.
			if (empty($errores)) {
				$datos = array(
					"id" => $_POST["idUsuario"],
					"usuario" => $_POST["EditarUsuario"],
					"correo" => $_POST["EditarCorreo"],
					"fecha_registro" => $_POST["EditarFecha"],
					"id_rol" => $_POST["EditarRol"],
				);

				$respuesta = Usuario::mdlEditarUsuario($datos);

				if ($respuesta == "ok") {
					$mensaje = Mensaje::obtenerMensaje(
						"success",
						"El usuario ha sido editado correctamente",
						null,
						"usuarios"
					);
				} else {
					$mensaje = Mensaje::obtenerMensaje(
						"error",
						"Ocurrió un error",
						$respuesta,
						"usuarios"
					);
				}
				echo $mensaje;
			} else {
				// Si hay errores, mostrarlos en un mensaje de error.
				$mensaje = Mensaje::obtenerMensaje(
					"error",
					"Entrada incorrecta",
					"Errores: " . implode(", ", $errores),
					"usuarios"
				);
				echo $mensaje;
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
