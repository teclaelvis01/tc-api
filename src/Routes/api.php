<?php

use App\Core\Router\Route;
use App\Http\Controllers\NotificationsController;


Route::post("/notifications/high", NotificationsController::class . "@high");
Route::post("/notifications/down", NotificationsController::class . "@down");
Route::post("/notifications/payment", NotificationsController::class . "@payment");
