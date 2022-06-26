<?php

namespace App\Core\Libraries\Traits;

/**
 * 
 * @author Elvis Reyes <teclaelvis01@gmail.com> 
 * @package App\Core\Libraries\Traits
 */
trait ModelManipulation
{
    protected static $instance = null;
    
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
}
