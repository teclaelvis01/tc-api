<?php

namespace App\Core\Libraries\Logguer;

/**
 * Logguer
 * @author Elvis Reyes <teclaelvis01@gmail.com> 
 * @package App\Core\Libraries\Logguer
 */
class Logguer
{
    const LOG_INFO = "INFO";
    const LOG_ERROR = "ERROR";
    const LOG_WARNING = "WARNING";
    const LOG_SUCCESS = "SUCCESS";

    /**
     * generate log file
     * @var string | array $message
     */
    private static function generateLog($message, $type = self::LOG_INFO)
    {
        $fileLog = APP_LOGS . "/telecomapi-" . date("Y-m-d") . ".log";
        // verify if file exists
        if (!file_exists($fileLog)) {
            // create folder if not exists
            if (!file_exists(APP_LOGS)) {
                mkdir(APP_LOGS, 0775, true);
            }
            touch($fileLog);
        }

        $logFile = fopen($fileLog, "a");
        if(is_array($message)){
            $message = json_encode($message);
        }
        $message = "[" . date("Y-m-d H:i:s") . "] " . $type . ": " . $message . "\n";
        fwrite($logFile, $message);
        fclose($logFile);
    }

    /**
     * info
     * @param string | array $message
     */
    public static function info($message)
    {
        self::generateLog($message, self::LOG_INFO);
    }
    /**
     * error
     * @param string | array $message
     */
    public static function error($message)
    {
        self::generateLog($message, self::LOG_ERROR);
    }
    /**
     * warning
     * @param string | array $message
     */
    public static function warning($message)
    {
        self::generateLog($message, self::LOG_WARNING);
    }
    /**
     * success
     * @param string | array $message
     */
    public static function success($message)
    {
        self::generateLog($message, self::LOG_SUCCESS);
    }
}
