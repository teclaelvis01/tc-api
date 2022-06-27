<?php

/**
 * Set error reporting level.
 */

use App\Core\Router\Route;
use App\Core\Database\DB;

require_once '../vendor/adodb/adodb-php/adodb-active-record.inc.php';

error_reporting(E_ALL);
/**
 * Set display errors.
 */
ini_set('display_errors', 1);

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
define('APP_LOGS', dirname(__DIR__) . '/logs');

define('PATH_ROUTES', __DIR__ . "/Routes/");
define('PATH_CONTROLLERS', __DIR__ . "/Http/Controllers/");

// database
$dbCredencials = require_once(__DIR__ . '/Config/database.conf.php');
$db = DB::run($dbCredencials);

/**
 * LOAD ROUTES
 */
$rutas = scandir(PATH_ROUTES);
foreach ($rutas as $archivo) {
    $rutaArchivo = realpath(PATH_ROUTES . $archivo);
    if (is_file($rutaArchivo)) {
        require $rutaArchivo;
    }
}

Route::run();
