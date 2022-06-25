<?php

/**
 * Set error reporting level.
 */

use App\Core\Router\RequestBase;
use App\Core\Router\Route;
use App\Core\Router\Uri;

error_reporting(E_ALL);

/**
 * Set display errors.
 */
ini_set('display_errors', 1);

/**
 * Composer autoload.
 */
// require __DIR__ . '/../vendor/autoload.php';


/**
 * Define root folder
 *
 * @var string
 */
define('ROOT_PATH', dirname(__DIR__));

/**
 * Define application path.
 *
 * @var string
 */
define('APP_PATH', __DIR__);

define('PATH_ROUTES', __DIR__ . "/Routes/");
define('PATH_CONTROLLERS', __DIR__ . "/Http/Controllers/");

$rutas = scandir(PATH_ROUTES);

foreach ($rutas as $archivo) {
    $rutaArchivo = realpath(PATH_ROUTES . $archivo);
    if (is_file($rutaArchivo)) {
        require $rutaArchivo;
    }
}

// var_dump(Route::class);
// die;
Route::run();
