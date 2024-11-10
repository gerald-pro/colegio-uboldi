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

	static public function listarPorPeriodo($fechaInicio, $fechaFin)
	{
		$fechaFin = date('Y-m-d', strtotime($fechaFin . ' +1 day'));

		$stmt = Conexion::conectar()->prepare("
            SELECT * FROM pagos 
            WHERE fecha BETWEEN :fechaInicio AND :fechaFin 
            ORDER BY fecha ASC
        ");
		$stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function listarPorApoderado($idApoderado)
	{
		$stmt = Conexion::conectar()->prepare("
            SELECT * 
            FROM pagos 
            WHERE id_apoderado = :id_apoderado
            ORDER BY fecha DESC
        ");
		$stmt->bindParam(":id_apoderado", $idApoderado, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function listarEstudiantesMayorPago()
	{
		$stmt = Conexion::conectar()->prepare("
            SELECT p.codigo as codigo_pago, concat(e.nombre, ' ', e.apellidos) as estudiante, concat(a.nombre, ' ', a.apellido) AS apoderado, p.monto_total AS monto_total
			FROM pagos p
			JOIN estudiantes e ON e.id = p.id_estudiante
			JOIN apoderados a ON a.id = p.id_apoderado
			ORDER BY monto_total desc
			limit 5
        ");
		$stmt->execute();
		return $stmt->fetchAll();
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
