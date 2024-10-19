<?php

require_once "conexion.php";

class DetalleCuota {

    /*=============================================
    MOSTRAR DETALLES DE CUOTAS
    =============================================*/

    static public function listar($item = null, $valor = null){
        if($item !== null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM detalle_cuotas WHERE $item = :$item");
            $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();

        }else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM detalle_cuotas");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    /*=============================================
    REGISTRO DE DETALLE DE CUOTA
    =============================================*/

    static public function crear($datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO detalle_cuotas (codigo, gestion, monto, n_cuotas) VALUES (:codigo, :gestion, :monto, :n_cuotas)");
        $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":gestion", $datos["gestion"], PDO::PARAM_INT);
        $stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_INT);
        $stmt->bindParam(":n_cuotas", $datos["n_cuotas"], PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
    }

    /*=============================================
    EDITAR DETALLE DE CUOTA
    =============================================*/

    static public function editar($datos){

        $stmt = Conexion::conectar()->prepare("UPDATE detalle_cuotas SET codigo = :codigo, gestion = :gestion, monto = :monto, n_cuotas = :n_cuotas WHERE id = :id");
        $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":gestion", $datos["gestion"], PDO::PARAM_INT);
        $stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_INT);
        $stmt->bindParam(":n_cuotas", $datos["n_cuotas"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
    }

    /*=============================================
    BORRAR DETALLE DE CUOTA
    =============================================*/

    static public function eliminar($datos){

        $stmt = Conexion::conectar()->prepare("DELETE FROM detalle_cuotas WHERE id = :id");
        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
    }
}
?>