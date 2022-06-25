<?php

namespace App\Core\Router;

class Route
{

    /**
     * 
     * @var Uri[] $uris
     */
    public static $uris = [];

    function __construct()
    {
    }

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

    public static function run(){
        $request = RequestBase::getInstance();
        $method = $request->requestMethod;
        // $uri = isset($_GET['uri']) ? $_GET['uri'] : "";
        $uri = self::parseUri($request->requestUri);

        foreach (Route::$uris as $key => $value) {
            // if($key ==1){
            //     var_dump("uri",$uri,$value->match($uri),$value);die;
            // }
            if ($value->match($uri)){
                return $value->call();
            }
        }

        header("Content-Type: application/json");
        echo json_encode(["message" => "Route Not found", "status" => 404, "method" => $method, "uri" => $uri]);
    }
}
