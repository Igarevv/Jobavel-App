<?php

declare(strict_types=1);

namespace App\Service\Account;

use App\Exceptions\AdminException\RolePermissions\InvalidRoleException;
use App\Persistence\Contracts\AccountRepositoryInterface;
use App\Persistence\Models\User;
use App\Persistence\Repositories\User\Employee\EmployeeAccountRepository;
use App\Persistence\Repositories\User\Employer\EmployerAccountRepository;

readonly class AccountRepositoryFactory
{

    public function __construct(private string $role)
    {
    }

    public function make(): AccountRepositoryInterface
    {
        return match ($this->role) {
            User::EMPLOYER => new EmployerAccountRepository(),
            User::EMPLOYEE => new EmployeeAccountRepository(),
            default => throw new InvalidRoleException('Tried to get repository for invalid role '.$this->role)
        };
    }

}
