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

    static public function listarPorApoderado($idApoderado)
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT c.gestion, c.mes, c.monto, c.fecha_vencimiento, p.codigo, concat(cs.nombre, cs.paralelo) as curso, concat(e.nombre, ' ',e.apellidos) as estudiante
            FROM cuotas c
            JOIN detalle_pago dp ON dp.id_cuota = c.id
            JOIN pagos p ON p.id = dp.id_pago
            JOIN cursos cs on cs.id = p.id_curso
            JOIN estudiantes e on e.id = p.id_estudiante
            WHERE p.id_apoderado = :id_apoderado
            ORDER BY c.fecha_vencimiento ASC
        ");
        $stmt->bindParam(":id_apoderado", $idApoderado, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
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
            SELECT 
                c.*
            FROM 
                cuotas c
            WHERE 
                c.id NOT IN (
                    SELECT dp.id_cuota
                    FROM detalle_pago dp
                    JOIN pagos p ON dp.id_pago = p.id
                    WHERE p.id_estudiante = :id_estudiante
                );
            ORDER BY c.fecha_vencimiento ASC
        ");

        $stmt->bindParam(":id_estudiante", $idEstudiante, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function cuotasPendientesDetalladoPorEstudiante($idEstudiante)
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT 
                CONCAT(e.nombre, ' ', e.apellidos) AS estudiante,
                CONCAT(c.nombre, c.paralelo) AS curso,
                ccuotas.gestion,
                ccuotas.mes,
                ccuotas.fecha_vencimiento,
                ccuotas.monto AS monto_cuota
            FROM 
                estudiantes e
            JOIN 
                cursos c ON e.id_curso = c.id
            JOIN 
                cuotas ccuotas ON NOT EXISTS (
                    SELECT 1 
                    FROM detalle_pago dp 
                    JOIN pagos p ON dp.id_pago = p.id 
                    WHERE p.id_estudiante = e.id AND dp.id_cuota = ccuotas.id
                )
            WHERE 
                e.id = :id_estudiante
            ORDER BY ccuotas.fecha_vencimiento ASC
        ");

        $stmt->bindParam(":id_estudiante", $idEstudiante, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function cuotasPendientesPorPeriodo($fechaInicio, $fechaFin)
    {
        $stmt = Conexion::conectar()->prepare("
        SELECT 
            e.id, 
            CONCAT(e.nombre, ' ', e.apellidos) AS estudiante,
            CONCAT(c.nombre, c.paralelo) AS curso,
            ccuotas.gestion,
            ccuotas.mes,
            ccuotas.fecha_vencimiento,
            ccuotas.monto AS monto_cuota
        FROM 
            estudiantes e
        JOIN 
            cursos c ON e.id_curso = c.id
        JOIN 
            cuotas ccuotas ON NOT EXISTS (
                SELECT 1 
                FROM detalle_pago dp 
                JOIN pagos p ON dp.id_pago = p.id 
                WHERE p.id_estudiante = e.id AND dp.id_cuota = ccuotas.id
            )
        WHERE 
            ccuotas.fecha_vencimiento BETWEEN :fechaInicio AND :fechaFin
        ORDER BY 
            e.nombre, e.apellidos, ccuotas.fecha_vencimiento;");

        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function listarCuotasPorPago($idPago)
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT c.*
            FROM detalle_pago dp
            JOIN cuotas c ON dp.id_cuota = c.id
            WHERE dp.id_pago = :id_pago
        ");

        $stmt->bindParam(":id_pago", $idPago, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
