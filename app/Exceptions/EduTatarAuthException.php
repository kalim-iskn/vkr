<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class EduTatarAuthException extends UnauthorizedHttpException
{
    public function __construct(string $challenge = '', string $message = '', \Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct($challenge, $message, $previous, $code, $headers);
    }
}
