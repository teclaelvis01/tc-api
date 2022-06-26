<?php

namespace App\Core\Libraries\Exceptions;

/**
 * TelecomException
 * @author Elvis Reyes <teclaelvis01@gmail.com> 
 * @package App\Core\Libraries\Exceptions
 */
class TelecomException extends \Exception
{
    /**
     * @var array
     */
    protected $messageArray;

    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        $this->messageArray = $message;

        if (is_string($message)) {
            parent::__construct($message, $code, $previous);
            return;
        }
        if (is_array($message)) {
            parent::__construct("Error as array", $code, $previous);
            return;
        }
        parent::__construct("Error unknon", $code, $previous);
    }

    public function getMessageAsArray()
    {
        return $this->messageArray;
    }
}
