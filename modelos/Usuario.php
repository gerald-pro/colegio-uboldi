<?php

require_once "conexion.php";

class Usuario{

	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function listar($item = null, $valor = null){

		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();

		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios");
			$stmt -> execute();
			return $stmt -> fetchAll();
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

	static public function mdlIngresarUsuario($datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO usuarios (usuario, correo, password, fecha_registro) VALUES (:usuario, :correo, :password, :fecha_registro)");
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_registro", $datos["fecha_registro"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";	
		}else{
			$error = $stmt->errorInfo();
			return $error[2];
		}
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarUsuario($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET usuario = :usuario, correo = :correo, fecha_registro = :fecha_registro WHERE usuario = :usuario");
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_registro", $datos["fecha_registro"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt -> execute()){
			return "ok";
		}else{
			$error = $stmt->errorInfo();
			return $error[2];	
		}
	}

	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/

	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			$error = $stmt->errorInfo();
			return $error[2];	
		}
	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function mdlBorrarUsuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
	}
}
