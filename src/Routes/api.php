<?php

use App\Core\Router\RequestBase;
use App\Core\Router\Route;
use App\Http\Controllers\NotificationsController;
use App\Http\Response;

// Route::get("/", function() {
//     return "Hola Deplynautas";
// });
// Route::post("/users/:nombre", function($nombre,RequestBase $request) {
//     $data = new \stdClass();
//     $data->name = $nombre;
//     $data->email = "teclas";
//     return [
//         "status" => "success",
//         "data" => $data, 
//     ];
//     // return (new Response())->json([
//     //     "status" => "success",
//     //     "data" => $data
//     // ]);
// });

Route::post("/users/:nombre", NotificationsController::class . "@index");
