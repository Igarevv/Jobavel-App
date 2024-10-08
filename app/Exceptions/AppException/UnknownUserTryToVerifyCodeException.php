<?php

declare(strict_types=1);

namespace App\Exceptions\AppException;

use Exception;

class UnknownUserTryToVerifyCodeException extends Exception
{
    public function render(): never
    {
        abort(404);
    }
}
