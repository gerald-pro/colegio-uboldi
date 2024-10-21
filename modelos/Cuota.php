<?php

require_once "conexion.php";

class Cuota
{
    static public function listar($item = null, $valor = null)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM cuotas WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM cuotas");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    static public function crear($datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO cuotas (gestion, mes, monto, fecha_vencimiento) VALUES (:gestion, :mes, :monto, :fecha_vencimiento)");
        $stmt->bindParam(":gestion", $datos["gestion"], PDO::PARAM_INT);
        $stmt->bindParam(":mes", $datos["mes"], PDO::PARAM_INT);
        $stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_vencimiento", $datos["fecha_vencimiento"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return $stmt->errorInfo()[2];
        }
    }

    static public function editar($datos)
    {
        if (isset($datos["id"])) {
            $stmt = Conexion::conectar()->prepare("UPDATE cuotas SET gestion = :gestion, mes = :mes, monto = :monto, fecha_vencimiento = :fecha_vencimiento WHERE id = :id");
            $stmt->bindParam(":gestion", $datos["gestion"], PDO::PARAM_INT);
            $stmt->bindParam(":mes", $datos["mes"], PDO::PARAM_INT);
            $stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_vencimiento", $datos["fecha_vencimiento"], PDO::PARAM_STR);
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
        $stmt = Conexion::conectar()->prepare("UPDATE cuotas SET $item1 = :$item1 WHERE $item2 = :$item2");
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
        $stmt = Conexion::conectar()->prepare("DELETE FROM cuotas WHERE id = :id");
        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return $stmt->errorInfo()[2];
        }
    }

    static public function listarPorGestion($gestion)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM cuotas WHERE gestion = :gestion ORDER BY mes ASC");
        $stmt->bindParam(":gestion", $gestion, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function listarCuotasPendientesPorEstudiante($idEstudiante)
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT c.*
            FROM cuotas c
            LEFT JOIN pagos p ON c.id = p.id_cuota AND p.id_estudiante = :id_estudiante
            WHERE p.id_cuota IS NULL
            ORDER BY c.fecha_vencimiento ASC
        ");

        $stmt->bindParam(":id_estudiante", $idEstudiante, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
