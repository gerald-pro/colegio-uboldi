<?php

require_once "conexion.php";

class DetallePago
{
    static public function crear($idPago, $idCuota, $monto): string
    {
        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO detalle_pago (id_pago, id_cuota, monto) 
            VALUES (:id_pago, :id_cuota, :monto)"
        );

        $stmt->bindParam(":id_pago", $idPago, PDO::PARAM_INT);
        $stmt->bindParam(":id_cuota", $idCuota, PDO::PARAM_INT);
        $stmt->bindParam(":monto", $monto, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return $stmt->errorInfo()[2];
        }
    }


    static public function listarPorPago($idPago): array
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM detalle_pago WHERE id_pago = :id_pago");
        $stmt->bindParam(":id_pago", $idPago, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    static public function eliminarPorPago($idPago): string
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM detalle_pago WHERE id_pago = :id_pago");
        $stmt->bindParam(":id_pago", $idPago, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return $stmt->errorInfo()[2];
        }
    }
}
