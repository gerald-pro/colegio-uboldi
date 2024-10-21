<?php

require_once "conexion.php";

class Pago
{
	static public function listar($item = null, $valor = null)
	{
		if ($item != null) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM pagos WHERE $item = :$item");
			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetch();
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM pagos");
			$stmt->execute();
			return $stmt->fetchAll();
		}
	}

	static public function crear($datos)
	{
		$stmt = Conexion::conectar()->prepare("INSERT INTO pagos (codigo, monto, id_estudiante, id_apoderado, id_curso, id_usuario, id_metodo_pago, id_cuota) VALUES (:codigo, :monto, :id_estudiante, :id_apoderado, :id_curso, :id_usuario, :id_metodo_pago, :id_cuota)");
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
		$stmt->bindParam(":id_estudiante", $datos["id_estudiante"], PDO::PARAM_INT);
		$stmt->bindParam(":id_apoderado", $datos["id_apoderado"], PDO::PARAM_INT);
		$stmt->bindParam(":id_curso", $datos["id_curso"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $_SESSION["id"], PDO::PARAM_INT);
		$stmt->bindParam(":id_metodo_pago", $datos["id_metodo_pago"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cuota", $datos["id_cuota"], PDO::PARAM_INT); 

		if ($stmt->execute()) {
			return "ok";
		} else {
			return $stmt->errorInfo()[2];
		}
	}

	static public function editar($datos)
	{
		if (isset($datos["id"])) {
			$stmt = Conexion::conectar()->prepare("UPDATE pagos SET codigo = :codigo, monto = :monto, id_estudiante = :id_estudiante, id_apoderado = :id_apoderado, id_curso = :id_curso, id_usuario = :id_usuario, id_metodo_pago = :id_metodo_pago, id_cuota = :id_cuota WHERE id = :id");

            $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
            $stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
            $stmt->bindParam(":id_estudiante", $datos["id_estudiante"], PDO::PARAM_INT);
            $stmt->bindParam(":id_apoderado", $datos["id_apoderado"], PDO::PARAM_INT);
            $stmt->bindParam(":id_curso", $datos["id_curso"], PDO::PARAM_INT);
            $stmt->bindParam(":id_usuario", $_SESSION["id"], PDO::PARAM_INT);
            $stmt->bindParam(":id_metodo_pago", $datos["id_metodo_pago"], PDO::PARAM_INT);
            $stmt->bindParam(":id_cuota", $datos["id_cuota"], PDO::PARAM_INT);
            $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

			if ($stmt->execute()) {
				return "ok";
			} else {
				return $stmt->errorInfo()[2];
			}
		} else {
			return "error";
		}
	}

	static public function actualizar($item1, $valor1, $item2, $valor2)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE pagos SET $item1 = :$item1 WHERE $item2 = :$item2");
		$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return $stmt->errorInfo()[2];
		}
	}

	static public function eliminar($datos)
	{
		$stmt = Conexion::conectar()->prepare("DELETE FROM pagos WHERE id = :id");
		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return $stmt->errorInfo()[2];
		}
	}

	static public function listarPorEstudiante($idEstudiante)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM pagos WHERE id_estudiante = :id_estudiante ORDER BY fecha ASC");
		$stmt->bindParam(":id_estudiante", $idEstudiante, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	}
}