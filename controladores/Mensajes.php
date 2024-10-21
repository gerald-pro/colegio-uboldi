<?php

class Mensaje
{
    public static function obtenerMensaje($tipo, $titulo, $mensaje, $redireccion): string
    {
        return '<script>
            swal({
                type: "' . $tipo . '",
                title: "' . $titulo . '",
                text: "' . $mensaje . '",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            }).then(function(result){
                if (result.value) {
                    window.location = "' . $redireccion . '";
                }
            })
        </script>';
    }
}
