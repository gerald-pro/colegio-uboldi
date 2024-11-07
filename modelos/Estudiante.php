<?php

require_once "conexion.php";

class Estudiante
{
    static public function crear($datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO estudiantes (nombre, apellidos, direccion, fecha_nacimiento, correo, telefono, id_curso, id_apoderado) 
                                                VALUES (:nombre, :apellidos, :direccion, :fecha_nacimiento, :correo, :telefono, :id_curso, :id_apoderado)");
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellidos", $datos["apellidos"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":id_curso", $datos["id_curso"], PDO::PARAM_INT);
        $stmt->bindParam(":id_apoderado", $datos["id_apoderado"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return $stmt->errorInfo()[2];
        }
    }

    static public function editar($datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE estudiantes SET nombre = :nombre, apellidos = :apellidos, direccion = :direccion, 
                                                fecha_nacimiento = :fecha_nacimiento, correo = :correo, telefono = :telefono, id_curso = :id_curso, id_apoderado = :id_apoderado 
                                                WHERE id = :id");
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellidos", $datos["apellidos"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":id_curso", $datos["id_curso"], PDO::PARAM_INT);
        $stmt->bindParam(":id_apoderado", $datos["id_apoderado"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return $stmt->errorInfo()[2];
        }
    }

    static public function eliminar($tabla, $id)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return $stmt->errorInfo()[2];
        }
    }

    static public function listar($item = null, $valor = null)
    {
        if ($item !== null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM estudiantes WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM estudiantes");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    static public function listarPorApoderado($idApoderado)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM estudiantes WHERE id_apoderado = :id_apoderado");
        $stmt->bindParam(":id_apoderado", $idApoderado, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function listarPorFechaRegistro($fechaInicio, $fechaFin)
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT * FROM estudiantes 
            WHERE fecha_registro BETWEEN :fechaInicio AND :fechaFin 
            ORDER BY fecha_registro ASC
        ");
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function listarPorCurso($idCurso)
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT e.*, concat(a.nombre, ' ', a.apellido) as apoderado FROM estudiantes e
            JOIN apoderados a on a.id = e.id_apoderado
            WHERE e.id_curso = :idCurso
            ORDER BY nombre ASC
        ");
        $stmt->bindParam(":idCurso", $idCurso, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function listarConCuotasPendientes()
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT e.id, e.nombre, e.apellidos, COUNT(c.id) AS cuotas_pendientes, SUM(c.monto) AS monto_total_pendiente
            FROM estudiantes e
            JOIN cuotas c ON NOT EXISTS (
                SELECT 1 
                FROM detalle_pago dp 
                JOIN pagos p ON dp.id_pago = p.id 
                WHERE p.id_estudiante = e.id AND dp.id_cuota = c.id
            )
            GROUP BY e.id, e.nombre, e.apellidos;
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
