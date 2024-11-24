<?php

class Rol
{
    /*=============================================
    LISTAR TODOS LOS ROLES
    =============================================*/
    static public function listar()
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM roles");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*=============================================
    OBTENER UN ROL POR ID
    =============================================*/
    static public function buscarPorId($id)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM roles WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*=============================================
    AGREGAR UN NUEVO ROL
    =============================================*/
    static public function crear($nombre)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO roles (nombre) VALUES (:nombre)");
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            $error = $stmt->errorInfo();
            return $error[2];
        }
    }

    /*=============================================
    ACTUALIZAR UN ROL
    =============================================*/
    static public function editar($id, $nombre)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE roles SET nombre = :nombre WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            $error = $stmt->errorInfo();
            return $error[2];
        }
    }

    /*=============================================
    ELIMINAR UN ROL
    =============================================*/
    static public function eliminar($id)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM roles WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            $error = $stmt->errorInfo();
            return $error[2];
        }
    }
}
