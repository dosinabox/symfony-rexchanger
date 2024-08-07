<?php

namespace App\Domain\Exchange\Exception;

use Symfony\Component\HttpFoundation\Response;

class UnauthorizedException extends \Exception
{
    public function __construct()
    {
        parent::__construct(message: 'Unauthorized', code: Response::HTTP_UNAUTHORIZED);
    }
}
