<?php

namespace App\Http\Controllers;

class BaseController
{
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
