<?php

namespace App\Domain\Exchange\Exception;

use Symfony\Component\HttpFoundation\Response;

class InvalidResponseException extends \Exception
{
    public function __construct()
    {
        parent::__construct(message: 'Response is invalid', code: Response::HTTP_NOT_ACCEPTABLE);
    }
}
