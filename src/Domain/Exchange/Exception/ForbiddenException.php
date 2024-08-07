<?php

namespace App\Domain\Exchange\Exception;

use Symfony\Component\HttpFoundation\Response;

class ForbiddenException extends \Exception
{
    public function __construct()
    {
        parent::__construct(message: 'Forbidden', code: Response::HTTP_FORBIDDEN);
    }
}
