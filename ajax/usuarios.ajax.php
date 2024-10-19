<?php

require_once "../controladores/UsuarioControlador.php";
require_once "../modelos/Usuario.php";

class AjaxUsuarios
{
	/*=============================================
	EDITAR USUARIO
	=============================================*/

	public $id;

	public function ajaxEditarUsuario()
	{

		$item = "id";
		$valor = $this->id;

		$respuesta = UsuarioControlador::listar($item, $valor);
		if ($respuesta) {
			echo json_encode($respuesta);
		} else {
			echo json_encode(["error" => "Usuario no encontrado"]);
		}
	}

	/*=============================================
	ACTIVAR USUARIO
	=============================================*/

	public $activarUsuario;
	public $activarId;


	public function ajaxActivarUsuario()
	{
		$tabla = "usuario";

		$item1 = "estado";
		$valor1 = $this->activarUsuario;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = Usuario::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
	}

	/*=============================================
	VALIDAR NO REPETIR USUARIO
	=============================================*/

	public $validarUsuario;

	public function ajaxValidarUsuario()
	{
		$item = "usuario";
		$valor = $this->validarUsuario;

		$respuesta = UsuarioControlador::listar($item, $valor);

		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR USUARIO
=============================================*/
if (isset($_POST["id"])) {
	$editar = new AjaxUsuarios();
	$editar->id = $_POST["id"];
	$editar->ajaxEditarUsuario();
}

/*=============================================
ACTIVAR USUARIO
=============================================*/

if (isset($_POST["activarUsuario"])) {
	$activarUsuario = new AjaxUsuarios();
	$activarUsuario->activarUsuario = $_POST["activarUsuario"];
	$activarUsuario->activarId = $_POST["activarId"];
	$activarUsuario->ajaxActivarUsuario();
}

/*=============================================
VALIDAR NO REPETIR USUARIO
=============================================*/

if (isset($_POST["validarUsuario"])) {

	$valUsuario = new AjaxUsuarios();
	$valUsuario->validarUsuario = $_POST["validarUsuario"];
	$valUsuario->ajaxValidarUsuario();
}
