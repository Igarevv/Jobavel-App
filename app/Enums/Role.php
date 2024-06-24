<?php

declare(strict_types=1);

namespace App\Enums;

use App\Persistence\Models\User;
use Illuminate\Database\Eloquent\Builder;

enum Role: string
{

    case EMPLOYER = 'employer';

    case EMPLOYEE = 'employee';

    public function roleMainPage(): string
    {
        return match ($this) {
            self::EMPLOYER => self::EMPLOYER->value.'.main',
            self::EMPLOYEE => self::EMPLOYEE->value.'.main',
            default => 'home'
        };
    }

    public function getModelByRole(User $user): ?Builder
    {
        return match ($this) {
            self::EMPLOYER => $user->employer(),
            self::EMPLOYEE => $user->employee(),
            default => null
        };
    }

}
