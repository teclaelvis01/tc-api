<?php

namespace App\Core\Router;

/**
 * @package App\Core\Router
 */
class RequestBase
{
    /**
     * @var string $serverProtocol
     */
    public $serverProtocol;
    /**
     * @var string $serverProtocol
     */
    public $requestUri;
    /**
     * @var string $serverProtocol
     */
    public $requestMethod;
    /**
     * 
     * @var array $queryParams
     */
    public $queryParams = [];

    /**
     * Stores instance for singleton pattern.
     *
     * @var $this
     */
    protected static $instance = null;

    public function __construct()
    {
        // singleton
        $this->bootstrap();
    }

    public static function getInstance($singleton = false)
    {
        if ($singleton) {
            if (self::$instance === null) {
                self::$instance = new static();
            }
            return self::$instance;
        } else {
            return new static();
        }
    }

    private function bootstrap(){
        foreach ($_SERVER as $key => $value) {
            $this->setProperty($key, $value);
        }
    }
    /**
     * set property
     * @param mixed $property 
     * @param mixed $value 
     * @return void 
     */
    public function setProperty($property, $value)
    {
        $property = $this->toCamelCase($property);
        if($property == "requestUri"){
            $path = strstr($value, '?', true);
            if($path){
                $this->queryParams = $this->getQueryParams($value);
                $value = $path;
            }
        }
        $this->$property = $value;
    }

    /**
     * convert query params to multidimensional array
     * ['param1' => 'value', 'param2' => 'value2']
     * @param string $params
     * @return array  
     */
    private function getQueryParams($uri)
    {
        $params = explode('&', substr(strstr(urldecode($uri), '?'), 1));
        $result = [];
        foreach ($params as $param) {
            $param = explode("=", $param);
            $result[$param[0]] = $param[1];
        }
        return $result;
    }

    private function toCamelCase($string)
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }
}
