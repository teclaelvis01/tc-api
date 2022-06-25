<?php


namespace App\Core\Exceptions;

/**
 * @author Elvis Reyes <teclaelvis01@gmail.com>
 */
class NotFoundHttpException extends HttpException
{
    /**
     * @param string|null     $message  The internal exception message
     * @param \Throwable|null $previous The previous exception
     * @param int             $code     The internal exception code
     */
    public function __construct(?string $message = '', \Throwable $previous = null, int $code = 0, array $headers = [])
    {
        if (null === $message) {
            $message = '';
        }

        parent::__construct(404, $message, $previous, $headers, $code);
    }
}
