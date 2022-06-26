<?php

namespace App\Http\Controllers;


/**
 * @author Elvis Reyes <teclaelvis01@gmail.com>
 * @package App\Http\Controllers
 */
class BaseController
{
   /**
    * 
    * @var \App\Core\Router\Request
    */
    protected $request;

    function getRequest()
    {
        return $this->request;
    }
    function setRequest($request)
    {
        $this->request = $request;
    }
}
