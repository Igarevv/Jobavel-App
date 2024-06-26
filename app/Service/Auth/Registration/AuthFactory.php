<?php

declare(strict_types=1);

namespace App\Service\Auth\Registration;

use App\Contracts\RoleAuthServiceInterface;
use App\Persistence\Contracts\UserRepositoryInterface;
use App\Persistence\Models\User;
use App\Service\Auth\Registration\Employee\EmployeeRegister;
use App\Service\Auth\Registration\Employer\EmployerRegister;
use InvalidArgumentException;

class AuthFactory
{

    public function __construct(
        private readonly UserRepositoryInterface $repository
    ) {}

    public function makeRegister(string $role): RoleAuthServiceInterface
    {
        return match ($role) {
            User::EMPLOYEE => new EmployeeRegister($this->repository),
            User::EMPLOYER => new EmployerRegister($this->repository),
            default => throw new InvalidArgumentException(
                'Invalid role provided'
            )
        };
    }

}
