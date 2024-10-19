<?php

require_once "conexion.php";

class Estudiante
{

    /*=============================================
    REGISTRO DE ESTUDIANTE
    =============================================*/

    static public function crear($datos)
    {
        $current_date = date('Y/m/d');
        $stmt = Conexion::conectar()->prepare("INSERT INTO estudiante (nombre, apellidos, direccion, fechanac, correo, telefono, fecharegistro, id_curso, paralelo, id_apoderado) 
                                                VALUES (:nombre, :apellidos, :direccion, :fechanac, :correo, :telefono, :fecharegistro, :id_curso, :paralelo, :id_apoderado)");
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellidos", $datos["apellidos"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":fechanac", $datos["fechanac"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":fecharegistro", $current_date, PDO::PARAM_STR);
        $stmt->bindParam(":id_curso", $datos["id_curso"], PDO::PARAM_INT);
        $stmt->bindParam(":paralelo", $datos["paralelo"], PDO::PARAM_STR);
        $stmt->bindParam(":id_apoderado", $datos["id_apoderado"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    /*=============================================
    EDITAR ESTUDIANTE
    =============================================*/

    static public function editar($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, apellidos = :apellidos, direccion = :direccion, 
                                                fechanac = :fechanac, correo = :correo, telefono = :telefono, id_curso = :id_curso, paralelo = :paralelo, id_apoderado = :id_apoderado 
                                                WHERE id = :id");
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellidos", $datos["apellidos"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":fechanac", $datos["fechanac"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":id_curso", $datos["id_curso"], PDO::PARAM_INT);
        $stmt->bindParam(":paralelo", $datos["paralelo"], PDO::PARAM_STR);
        $stmt->bindParam(":id_apoderado", $datos["id_apoderado"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            $error = $stmt->errorInfo();
            return "error";
        }
    }

    /*=============================================
    ELIMINAR ESTUDIANTE
    =============================================*/

    static public function eliminar($tabla, $id)
    {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    /*=============================================
    MOSTRAR ESTUDIANTES
    =============================================*/

    static public function listar($item = null, $valor = null)
    {
        if ($item !== null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM estudiante WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM estudiante");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
}