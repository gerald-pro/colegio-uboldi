<?php

require_once "conexion.php";

class Pago
{
	/*=============================================
    MOSTRAR PAGOS
    =============================================*/
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

	/*=============================================
    REGISTRO DE PAGO
    =============================================*/

	static public function crear($datos)
	{
		$fecha_actual = date('Y/m/d H:i:s');

		$stmt = Conexion::conectar()->prepare("INSERT INTO pagos (codigo, gestion, fecha, hora, monto, id_estudiante, id_apoderado, id_curso, id_usuario, id_metodo_pago) VALUES (:codigo, :gestion, :fecha, :hora, :monto, :id_estudiante, :id_apoderado, :id_curso, :id_usuario, :id_metodo_pago)");
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":gestion", $datos["gestion"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $fecha_actual, PDO::PARAM_STR);
		$stmt->bindParam(":hora", $fecha_actual, PDO::PARAM_STR);
		$stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);

		$stmt->bindParam(":id_estudiante", $datos["id_estudiante"], PDO::PARAM_INT);
		$stmt->bindParam(":id_apoderado", $datos["id_apoderado"], PDO::PARAM_INT);
		$stmt->bindParam(":id_curso", $datos["id_curso"], PDO::PARAM_INT);

		$stmt->bindParam(":id_usuario", $_SESSION["id"], PDO::PARAM_INT);
		$stmt->bindParam(":id_metodo_pago", $datos["id_metodo_pago"], PDO::PARAM_INT);


		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}

	/*=============================================
    EDITAR PAGO
    =============================================*/

	static public function editar($datos)
	{
		if (isset($datos["id"])) {
			$fecha_actual = date('Y/m/d H:i:s');

			$stmt = Conexion::conectar()->prepare("UPDATE pagos SET codigo= :codigo, hora = :hora, monto = :monto, id_estudiante = :id_estudiante, id_apoderado = :id_apoderado, id_curso = :id_curso, id_usuario = :id_usuario WHERE id = :id");
			$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
			$stmt->bindParam(":hora", $fecha_actual, PDO::PARAM_STR);
			$stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);

			$stmt->bindParam(":id_estudiante", $datos["id_estudiante"], PDO::PARAM_INT);
			$stmt->bindParam(":id_apoderado", $datos["id_apoderado"], PDO::PARAM_INT);
			$stmt->bindParam(":id_curso", $datos["id_curso"], PDO::PARAM_INT);

			$stmt->bindParam(":id_usuario", $_SESSION["id"], PDO::PARAM_INT);
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
    ACTUALIZAR PAGO
    =============================================*/

	static public function actualizar($item1, $valor1, $item2, $valor2)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE pagos SET $item1 = :$item1 WHERE $item2 = :$item2");
		$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}

	/*=============================================
    BORRAR PAGO
    =============================================*/

	static public function eliminar($datos)
	{
		$stmt = Conexion::conectar()->prepare("DELETE FROM pagos WHERE id = :id");
		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}

	/*=============================================
     OBTENER HISTORIAL DE PAGOS POR ESTUDIANTE
    =============================================*/
	static public function listarPorEstudiante($idEstudiante)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM pagos WHERE id_estudiante = :id_estudiante ORDER BY fecha ASC");
		$stmt->bindParam(":id_estudiante", $idEstudiante, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	}
}
