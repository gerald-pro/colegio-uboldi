<?php

require_once "conexion.php";

class MetodoPago
{
    static public function listar()
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM metodos_pago");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function buscarPorId($id)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM metodos_pago WHERE id = $id");
        $stmt->execute();
        return $stmt->fetch();
    }
}
