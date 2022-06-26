<?php

namespace App\Core\Router;


use Closure;

/**
 * Class Uri
 * @author Elvis Reyes <teclaelvis01@gmail.com>
 * @package App\Core\Router
 */
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
        if ($this->method != Request::getInstance()->requestMethod && $this->method != "ANY") {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    private function execFunction()
    {
        $this->matches[] = Request::getInstance();
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
        $classInstance->setRequest(Request::getInstance());
        
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
    /**
     * Initialize the router with controller and method to execute
     * or a closure and method to execute
     * @return void 
     */
    public function call()
    {
        try {
            
            if ($this->function instanceof Closure) {
                $this->execFunction();
            }
            if (is_string($this->function)) {
                $this->execFunctionFromController();
            }
        } catch (\Exception $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
}
