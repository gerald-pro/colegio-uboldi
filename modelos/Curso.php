<?php

require_once "conexion.php";

class Curso
{
	/*=============================================
	MOSTRAR CURSOS
	=============================================*/

	static public function listar($item = null, $valor = null)
	{
		if ($item != null) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM curso WHERE $item = :$item");
			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetch();
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM curso");
			$stmt->execute();
			return $stmt->fetchAll();
		}
	}

	static public function buscarPorId($id)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM curso WHERE id = $id");
		$stmt->execute();
		return $stmt->fetch();
	}

	/*=============================================
	REGISTRO DE CURSO
	=============================================*/

	static public function crear($tabla, $datos)
	{
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (curso, paralelo) VALUES (:curso, :paralelo)");
		$stmt->bindParam(":curso", $datos["curso"], PDO::PARAM_STR);
		$stmt->bindParam(":paralelo", $datos["paralelo"], PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}

	/*=============================================
	EDITAR CURSO
	=============================================*/

	static public function editar($datos)
	{
		if (isset($datos["curso"]) && isset($datos["paralelo"]) && isset($datos["id"])) {
			$stmt = Conexion::conectar()->prepare("UPDATE curso SET curso = :curso, paralelo = :paralelo WHERE id = :id");
			$stmt->bindParam(":curso", $datos["curso"], PDO::PARAM_STR);
			$stmt->bindParam(":paralelo", $datos["paralelo"], PDO::PARAM_STR);
			$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

			if ($stmt->execute()) {
				return "ok";
			} else {
				return "error";
			}
		} else {
			return "error";
		}
	}

	/*=============================================
	ACTUALIZAR CURSO
	=============================================*/

	static public function actualizar($tabla, $item1, $valor1, $item2, $valor2)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
		$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}

	/*=============================================
	BORRAR CURSO
	=============================================*/

	static public function eliminar($tabla, $datos)
	{
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}
}
