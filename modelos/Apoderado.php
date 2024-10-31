<?php

require_once "conexion.php";

class Apoderado {

    /*=============================================
    MOSTRAR APODERADOS
    =============================================*/

    static public function listar($item = null, $valor = null){
        if($item !== null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM apoderados WHERE $item = :$item");
            $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();

        }else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM apoderados");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    static public function buscarPorId($id)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM apoderados WHERE id = $id");
		$stmt->execute();
		return $stmt->fetch();
	}

    static public function buscarPorEstudiante($idEstudiante)
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT a.*
            FROM apoderados a
            JOIN estudiantes e ON a.id = e.id_apoderado
            WHERE e.id = :id_estudiante
        ");

        $stmt->bindParam(":id_estudiante", $idEstudiante, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    /*=============================================
    REGISTRO DE APODERADO
    =============================================*/

    static public function crear($datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO apoderados (nombre, apellido, direccion, telefono, id_usuario) VALUES (:nombre, :apellido, :direccion, :telefono, :id_usuario)");
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
    }

    /*=============================================
    EDITAR APODERADO
    =============================================*/

    static public function editar($datos){

        $stmt = Conexion::conectar()->prepare("UPDATE apoderados SET nombre = :nombre, apellido = :apellido, Direccion = :direccion, telefono = :telefono, id_usuario = :id_usuario WHERE id = :id");
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
    }

    /*=============================================
    BORRAR APODERADO
    =============================================*/

    static public function eliminar($datos){

        $stmt = Conexion::conectar()->prepare("DELETE FROM apoderados WHERE id = :id");
        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
    }
}
