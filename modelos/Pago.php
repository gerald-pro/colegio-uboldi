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
		$conexion = Conexion::conectar();
        $stmt = $conexion->prepare(
            "INSERT INTO pagos (codigo, monto_total, id_estudiante, id_apoderado, id_curso, id_usuario, id_metodo_pago) 
            VALUES (:codigo, :monto_total, :id_estudiante, :id_apoderado, :id_curso, :id_usuario, :id_metodo_pago)"
        );

        $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":monto_total", $datos["monto_total"], PDO::PARAM_STR); // Monto total ahora
        $stmt->bindParam(":id_estudiante", $datos["id_estudiante"], PDO::PARAM_INT);
        $stmt->bindParam(":id_apoderado", $datos["id_apoderado"], PDO::PARAM_INT);
        $stmt->bindParam(":id_curso", $datos["id_curso"], PDO::PARAM_INT);
        $stmt->bindParam(":id_usuario", $_SESSION["id"], PDO::PARAM_INT);
        $stmt->bindParam(":id_metodo_pago", $datos["id_metodo_pago"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            $lastId = $conexion->lastInsertId();
			return $lastId;
        } else {
			$error = $stmt->errorInfo();
			return $error;
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