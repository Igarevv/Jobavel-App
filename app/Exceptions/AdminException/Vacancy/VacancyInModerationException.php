<?php

declare(strict_types=1);

namespace App\Exceptions\AdminException\Vacancy;

use App\Exceptions\AppException\VacancyStatusException;
use Throwable;

class VacancyInModerationException extends VacancyStatusException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Vacancy has not been moderated yet.', $code, $previous);
    }

}
