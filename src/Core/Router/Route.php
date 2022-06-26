<?php

namespace App\Core\Router;

use App\Http\Response;

/**
 * Class Route
 * @author Elvis Reyes <teclaelvis01@gmail.com>
 * @package App\Core\Router
 */
class Route
{

    /**
     * list of uris class registered
     * @var Uri[] $uris
     */
    public static $uris = [];

    public static function add($method, $uri, $fuction = null)
    {
        Route::$uris[] = new Uri(self::parseUri($uri), $method, $fuction);
        return;
    }

    public static function get($uri, $fuction = null)
    {
        return Route::add("GET", $uri, $fuction);
    }
    public static function post($uri, $fuction = null)
    {
        return Route::add("POST", $uri, $fuction);
    }
    public static function put($uri, $fuction = null)
    {
        return Route::add("PUT", $uri, $fuction);
    }
    public static function delete($uri, $fuction = null)
    {
        return Route::add("DELETE", $uri, $fuction);
    }
    public static function any($uri, $fuction = null)
    {
        return Route::add("ANY", $uri, $fuction);
    }

    private static function parseUri($uri)
    {
        $uri = trim($uri, "/");
        $uri = (strlen($uri) > 0) ? $uri : "/";
        return $uri;
    }
    /** 
     * Initialize the router
     */
    public static function run()
    {
        $request = Request::getInstance();
        $method = $request->requestMethod;
        $uri = self::parseUri($request->requestUri);

        foreach (Route::$uris as $key => $value) {
            if ($value->match($uri)) {
                return $value->call();
            }
        }

        header("Content-Type: application/json");
        echo Response::json(["Error" => "Route Not Found", "method" => $method, "uri" => $uri], Response::HTTP_NOT_FOUND);
    }
}
