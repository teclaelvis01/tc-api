<?php

namespace App\Core\Router;

class Request extends RequestBase
{
    protected $request;
    protected $data;
    public $method;

    public function __construct($request, $flag = true)
    {
        $this->request = $request;
        $this->extracData();
        $this->setExtraData($flag);
    }

    public function extracData()
    {
        $this->data = [];
        foreach ($this->request as $key => $value) {
            if (is_object($value) || is_array($value)) {
                $this->data[$key] = new Request($value, false);
            } else {
                if ($key != "http_referer") {
                    $this->data[$key] = $value;
                }
            }
        }
    }

    public function setExtraData($flag)
    {
        if ($flag) {
            $this->method = $_SERVER["REQUEST_METHOD"];
            $this->data["http_referer"] = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : null;
            $headers = apache_request_headers();
            // var_dump("headers",$headers);die;
            $this->data["headers"] = new Request($headers, false);
        }
    }

    public function __get($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
    public function all(){
        return $this->data;
    } 
}
