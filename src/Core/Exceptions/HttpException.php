<?php
namespace App\Core\Exceptions;

/**
 * HttpException.
 *
 * @author Elvis Reyes <teclaelvis01@gmail.com>
 */
class HttpException extends \RuntimeException
{
    private $statusCode;
    private $headers;

    public function __construct(int $statusCode, ?string $message = '', \Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        if (null === $message) {
            $message = '';
        }
        if (null === $code) {
            $code = 0;
        }

        $this->statusCode = $statusCode;
        $this->headers = $headers;

        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set response headers.
     *
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }
}
