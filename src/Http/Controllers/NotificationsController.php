<?php

namespace App\Http\Controllers;

class NotificationsController extends BaseController
{
    public function index($nombre)
    {
        $data = new \stdClass();
        $data->name = $nombre;
        $data->email = "teclas";
        return [
            "status" => "success",
            "data" => $data, 
        ];
    }
}