<?php

namespace App\Core\Helpers;

use App\Http\Response;

class ReponseMessages
{

    const CORRECTO = "CORRECTO";
    const ERROR = "ERROR";
    const INSERCION_EXITOSA = "INSERSION_EXITOSA";
    const ACTUALIZACION_EXITOSA = "ACTUALIZACION_EXITOSA";
    const ELIMINACION_EXITOSA = "ELIMINACION_EXITOSA";
    const ERROR_INSERSION = "ERROR_INSERSION";
    const ERROR_ACTUALIZACION = "ERROR_ACTUALIZACION";
    const ERROR_ELIMINACION = "ERROR_ELIMINACION";
    const NO_HAY_REGISTROS = "NO_HAY_REGISTROS";
    const ERROR_CONEXION_BD = "ERROR_CONEXION_BD";

    public static function getMensaje($codigo)
    {
        switch ($codigo) {
            case ReponseMessages::CORRECTO:
                return new Response(1, "Se ha realizado la operación de manera correcta.");
            case ReponseMessages::INSERCION_EXITOSA:
                return new Response(1, "Se ha insertado el registro con éxito.");
            case ReponseMessages::ACTUALIZACION_EXITOSA:
                return new Response(1, "Se ha actualizado el registro con éxito.");
            case ReponseMessages::ELIMINACION_EXITOSA:
                return new Response(1, "Se ha eliminado el registro con éxito.");
            case ReponseMessages::ERROR_INSERSION:
                return new Response(-1, "Se ha producido un error al insertar el registro.");
            case ReponseMessages::ERROR:
                return new Response(-1, "Se ha producido un error al realizar la operación.");
            case ReponseMessages::ERROR_ACTUALIZACION:
                return new Response(-1, "Se ha producido un error al acutalizar el registro.");
            case ReponseMessages::ERROR_ELIMINACION:
                return new Response(-1, "Se ha producio un error al eliminar el registro.");
            case ReponseMessages::NO_HAY_REGISTROS:
                return new Response(0, "No hay registros.");
            case ReponseMessages::ERROR_CONEXION_BD:
                return new Response(-1, "Error al conectar con la base de datos.");
        }
    }
}
