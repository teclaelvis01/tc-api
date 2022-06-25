<?php

namespace App\Core\Router;

use App\Http\Response;
use Closure;
use ReflectionMethod;

class Uri
{
    var $uri;
    var $method;
    var $function;
    var $matches;

    protected $request;
    protected $response;

    /**
     * 
     * @param string $uri 
     * @param string $method 
     * @param Closure | string $function 
     * @return void 
     */
    public function __construct($uri, $method, $function)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->function = $function;
    }

    public function match($uri)
    {
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->uri);
        $regex = "#^$path$#i";

        if (!preg_match($regex, urldecode($uri), $matches)) {
            return false;
        }
        if ($this->method != RequestBase::getInstance()->requestMethod && $this->method != "ANY") {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    private function execFunction()
    {
        $this->matches[] = RequestBase::getInstance();
        $this->response = call_user_func_array($this->function, $this->matches);
    }
    private function getParts()
    {
        $parts = [];
        if (strpos($this->function, "@")) {
            $methodParts = explode("@", $this->function);
            $parts["class"] = $methodParts[0];
            $parts["method"] = $methodParts[1];
        } else {
            $parts["class"] = $this->function;
            $parts["method"] =  "index";
        }

        return $parts;
    }
    private function execFunctionFromController()
    {
        $parts = $this->getParts();
        $class = $parts["class"];
        $method = $parts["method"];
        // importar the controller
        if(!$this->impoprtController($this->getClassOnly($class))){
            return;
        }
        $classInstance = new $class();
        $classInstance->setRequest(RequestBase::getInstance());
        
        $launch = [$classInstance, $method];
        if (is_callable($launch)){
            $this->response = call_user_func_array($launch, $this->matches);
        } else{
            throw new \Exception("Method ".$class.$method." not found", -1);
        }

    }

    /**
     * 
     * @param string $class 
     * @return string 
     */
    private function getClassOnly(string $class): string{
        // remove namespace
        $lastOccurence = strrpos($class, "\\");
        if($lastOccurence){
            $class = substr($class, $lastOccurence + 1);
        }
        return $class;
    }

    public function impoprtController($class)
    {        
        
        $file = PATH_CONTROLLERS . $class . ".php";
        if (!file_exists($file)) {
            throw new \Exception("Controller not found");
            return false;
        }
        require_once $file;
        return true;
    }

    public function call()
    {
        try {
            
            if ($this->function instanceof Closure) {
                $this->execFunction();
            }
            if (is_string($this->function)) {
                $this->execFunctionFromController();
            }
            $this->printResponse();
        } catch (\Exception $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    private function printResponse()
    {
        if (is_string($this->response)) {
            echo $this->response;
        } else if (is_array($this->response) || is_object($this->response)) {
            $res = new Response();
            echo $res->json($this->response);
        }
    }
}
