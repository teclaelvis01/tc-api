<?php

namespace App\Core\Router;

use App\Core\Libraries\Traits\ModelManipulation;

/**
 * Request
 * 
 * @author Elvis Reyes <teclaelvis01@gmail.com>
 * @package App\Core\Router
 */
class Request
{
    use ModelManipulation;
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
     * @var array $queryParams
     */
    public $queryParams = [];
    /**
     * @var array $queryBody
     */
    public $queryBody = [];


    public function __construct()
    {
        $this->bootstrap();
    }


    private function bootstrap()
    {
        foreach ($_SERVER as $key => $value) {
            $this->setProperty($key, $value);
        }
        $rawData = file_get_contents('php://input');
        if (!empty($rawData)) {
            $this->queryBody = json_decode($rawData, true);
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
        if ($property == "requestUri") {
            $path = strstr($value, '?', true);
            if ($path) {
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
    /**
     * convert string to camel case
     * @param string $string
     * @return string
     */
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

    /**
     * get param by key
     * @param mixed $key 
     * @return mixed | null 
     */
    public function get($key)
    {
        // verify if key exists on queryParams
        if (array_key_exists($key, $this->queryParams)) {
            return $this->queryParams[$key];
        }
        if (array_key_exists($key, $this->queryBody)) {
            return $this->queryBody[$key];
        }
        return null;
    }

    /**
     * get all params
     * @return array 
     */
    public function all(){
        return array_merge($this->queryParams, $this->queryBody);
    }
}
