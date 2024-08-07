<?php

namespace App\Domain\Exchange\Exception;

use Symfony\Component\HttpFoundation\Response;

class ServiceUnavailableException extends \Exception
{
    public function __construct()
    {
        parent::__construct(message: 'Service unavailable', code: Response::HTTP_SERVICE_UNAVAILABLE);
    }
}
