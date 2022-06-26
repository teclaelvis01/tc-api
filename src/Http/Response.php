<?php

namespace App\Http;

use App\Core\Libraries\HttpResponse;

/**
 * @author Elvis Reyes <teclaelvis01@gmail.com>
 * @package App\Http
 */
class Response extends HttpResponse
{


    /**
     * return a json response
     * author: Elvis Reyes <teclaelvis01@gmail.com>
     * @param mixed $obj 
     * @param int $code 
     * @return never 
     */
    public static function json($obj = null, $code = Response::HTTP_OK)
    {
        header('Content-Type: application/json');
        // add http status code
        http_response_code($code);
        if (is_array($obj) || is_object($obj)) {
            echo json_encode($obj);
            die;
        }
        echo json_encode([]);
        die;
    }
}
