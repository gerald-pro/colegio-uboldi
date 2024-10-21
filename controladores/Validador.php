<?php
class Validador
{
    /**
     * Valida si un nombre es válido.
     * Requisitos: Solo letras y espacios, longitud mínima de 2 caracteres.
     * 
     * @param string $nombre
     * @return bool
     */
    public static function validarNombre($nombre): bool
    {
        return preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,}$/", $nombre);
    }

    /**
     * Valida si un correo electrónico es válido.
     * 
     * @param string $correo
     * @return bool
     */
    public static function validarCorreo($correo): bool
    {
        return filter_var($correo, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Valida si una cadena es un número entero.
     * 
     * @param mixed $numero
     * @return bool
     */
    public static function validarEntero($numero): bool
    {
        return filter_var($numero, FILTER_VALIDATE_INT) !== false;
    }

    /**
     * Valida si una cadena es un número flotante.
     * 
     * @param mixed $numero
     * @return bool
     */
    public static function validarFlotante($numero): bool
    {
        return filter_var($numero, FILTER_VALIDATE_FLOAT) !== false;
    }

    /**
     * Valida si una fecha tiene el formato correcto (YYYY-MM-DD).
     * 
     * @param string $fecha
     * @return bool
     */
    public static function validarFecha($fecha): bool
    {
        $formato = 'Y-m-d';
        $d = DateTime::createFromFormat($formato, $fecha);
        return $d && $d->format($formato) === $fecha;
    }

    /**
     * Valida si una URL es válida.
     * 
     * @param string $url
     * @return bool
     */
    public static function validarURL($url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Valida si un campo no está vacío.
     * 
     * @param string $campo
     * @return bool
     */
    public static function validarNoVacio($campo): bool
    {
        return !empty(trim($campo));
    }

    /**
     * Valida si un número está dentro de un rango.
     * 
     * @param int|float $numero
     * @param int|float $min
     * @param int|float $max
     * @return bool
     */
    public static function validarRango($numero, $min, $max): bool
    {
        return $numero >= $min && $numero <= $max;
    }

    /**
     * Valida si una cadena tiene una longitud mínima y máxima.
     * 
     * @param string $cadena
     * @param int $min
     * @param int $max
     * @return bool
     */
    public static function validarLongitud($cadena, $min, $max): bool
    {
        $longitud = strlen($cadena);
        return $longitud >= $min && $longitud <= $max;
    }

    /**
     * Valida si un campo tiene formato de solo números.
     * 
     * @param string $campo
     * @return bool
     */
    public static function validarSoloNumeros($campo): bool
    {
        return preg_match('/^[0-9]+$/', $campo);
    }
}
