<?php

class Validador
{
    /**
     * Valida si un nombre es válido.
     * Requisitos: Solo letras y espacios, longitud mínima de 2 caracteres.
     *
     * @param string $nombre
     * @param string $campo
     * @return array
     */
    public static function validarNombre($nombre, $campo = "El campo"): array
    {
        $valido = preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,}$/", $nombre);
        return [
            "valido" => $valido,
            "mensaje" => $valido ? "" : "$campo debe contener solo letras y espacios, con al menos 2 caracteres."
        ];
    }

    /**
     * Valida si un correo electrónico es válido.
     *
     * @param string $correo
     * @param string $campo
     * @return array
     */
    public static function validarCorreo($correo, $campo = "El correo"): array
    {
        $valido = filter_var($correo, FILTER_VALIDATE_EMAIL) !== false;
        return [
            "valido" => $valido,
            "mensaje" => $valido ? "" : "$campo no es válido."
        ];
    }

    /**
     * Valida si una cadena es un número entero.
     *
     * @param mixed $numero
     * @param string $campo
     * @return array
     */
    public static function validarEntero($numero, $campo = "El valor"): array
    {
        $valido = filter_var($numero, FILTER_VALIDATE_INT) !== false;
        return [
            "valido" => $valido,
            "mensaje" => $valido ? "" : "$campo debe ser un número entero."
        ];
    }

    /**
     * Valida si una cadena es un número flotante.
     *
     * @param mixed $numero
     * @param string $campo
     * @return array
     */
    public static function validarFlotante($numero, $campo = "El valor"): array
    {
        $valido = filter_var($numero, FILTER_VALIDATE_FLOAT) !== false;
        return [
            "valido" => $valido,
            "mensaje" => $valido ? "" : "$campo debe ser un número flotante."
        ];
    }

    /**
     * Valida si una fecha tiene el formato correcto (YYYY-MM-DD).
     *
     * @param string $fecha
     * @param string $campo
     * @return array
     */
    public static function validarFecha($fecha, $campo = "La fecha"): array
    {
        $formato = 'Y-m-d';
        $d = DateTime::createFromFormat($formato, $fecha);
        $valido = $d && $d->format($formato) === $fecha;
        return [
            "valido" => $valido,
            "mensaje" => $valido ? "" : "$campo debe estar en formato YYYY-MM-DD."
        ];
    }

    /**
     * Valida si una URL es válida.
     *
     * @param string $url
     * @param string $campo
     * @return array
     */
    public static function validarURL($url, $campo = "La URL"): array
    {
        $valido = filter_var($url, FILTER_VALIDATE_URL) !== false;
        return [
            "valido" => $valido,
            "mensaje" => $valido ? "" : "$campo no es válida."
        ];
    }

    /**
     * Valida si un campo no está vacío.
     *
     * @param string $campo
     * @param string $campoNombre
     * @return array
     */
    public static function validarNoVacio($campo, $campoNombre = "El campo"): array
    {
        $valido = !empty(trim($campo));
        return [
            "valido" => $valido,
            "mensaje" => $valido ? "" : "$campoNombre no puede estar vacío."
        ];
    }

    /**
     * Valida si un número está dentro de un rango.
     *
     * @param int|float $numero
     * @param int|float $min
     * @param int|float $max
     * @param string $campo
     * @return array
     */
    public static function validarRango($numero, $min, $max, $campo = "El valor"): array
    {
        $valido = $numero >= $min && $numero <= $max;
        return [
            "valido" => $valido,
            "mensaje" => $valido ? "" : "$campo debe estar entre $min y $max."
        ];
    }

    /**
     * Valida si una cadena tiene una longitud mínima y máxima.
     *
     * @param string $cadena
     * @param int $min
     * @param int $max
     * @param string $campo
     * @return array
     */
    public static function validarLongitud($cadena, $min, $max, $campo = "La longitud"): array
    {
        $longitud = strlen($cadena);
        $valido = $longitud >= $min && $longitud <= $max;
        return [
            "valido" => $valido,
            "mensaje" => $valido ? "" : "$campo debe estar entre $min y $max caracteres."
        ];
    }

    /**
     * Valida si un campo tiene formato de solo números.
     *
     * @param string $campo
     * @param string $campoNombre
     * @return array
     */
    public static function validarSoloNumeros($campo, $campoNombre = "El campo"): array
    {
        $valido = preg_match('/^[0-9]+$/', $campo);
        return [
            "valido" => $valido,
            "mensaje" => $valido ? "" : "$campoNombre solo puede contener números."
        ];
    }

    /**
     * Valida si un nombre de usuario es válido.
     * Requisitos: Solo letras, números y guiones bajos.
     *
     * @param string $username
     * @param string $campo
     * @return array
     */
    public static function validarUsername($username, $campo = "El nombre de usuario"): array
    {
        $valido = preg_match("/^[a-zA-Z0-9_]+$/", $username);
        return [
            "valido" => $valido,
            "mensaje" => $valido ? "" : "$campo solo puede contener letras, números y guiones bajos."
        ];
    }

    /**
     * Valida si una contraseña es válida.
     * Requisitos: No estar vacía.
     *
     * @param string $password
     * @param string $campo
     * @return array
     */
    public static function validarPassword($password, $campo = "La contraseña"): array
    {
        $valido = is_string($password) && $password !== '';
        return [
            "valido" => $valido,
            "mensaje" => $valido ? "" : "$campo no puede estar vacía."
        ];
    }
}
