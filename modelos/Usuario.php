<?php

require_once "conexion.php";

class Usuario
{

	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function listar($item = null, $valor = null)
	{

		if ($item != null) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE $item = :$item");
			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetch();
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios");
			$stmt->execute();
			return $stmt->fetchAll();
		}
	}

	static public function buscarPorId($id)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE id = $id");
		$stmt->execute();
		return $stmt->fetch();
	}

	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function mdlIngresarUsuario($datos)
	{
		$stmt = Conexion::conectar()->prepare("
			INSERT INTO usuarios (usuario, correo, password, fecha_registro, id_rol) 
			VALUES (:usuario, :correo, :password, :fecha_registro, :id_rol)
		");
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_registro", $datos["fecha_registro"], PDO::PARAM_STR);
		$stmt->bindParam(":id_rol", $datos["id_rol"], PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "ok";
		} else {
			$error = $stmt->errorInfo();
			return $error[2];
		}
	}


	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarUsuario($datos)
	{
		$stmt = Conexion::conectar()->prepare("
        UPDATE usuarios 
        SET usuario = :usuario, correo = :correo, fecha_registro = :fecha_registro, id_rol = :id_rol 
        WHERE id = :id
    ");
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_registro", $datos["fecha_registro"], PDO::PARAM_STR);
		$stmt->bindParam(":id_rol", $datos["id_rol"], PDO::PARAM_INT);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "ok";
		} else {
			$error = $stmt->errorInfo();
			return $error[2];
		}
	}

	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/

	static public function mdlActualizarUsuario($idUsuario, $fecha_ultima_sesion)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE usuarios SET fecha_ultima_sesion = :fecha_ultima_sesion WHERE id = $idUsuario");
		$stmt->bindParam(":fecha_ultima_sesion", $fecha_ultima_sesion, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		} else {
			$error = $stmt->errorInfo();
			return $error[2];
		}
	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function mdlBorrarUsuario($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}

	public static function obtenerRol($usuario_id)
	{
		$stmt = Conexion::conectar()->prepare("
            SELECT roles.nombre 
            FROM usuarios 
            INNER JOIN roles ON usuarios.id_rol = roles.id 
            WHERE usuarios.id = :usuario_id
        ");
		$stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC)['nombre'] ?? null;
	}
}
