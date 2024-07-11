<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\User;

use App\Persistence\Contracts\AccountRepositoryInterface;
use App\Persistence\Models\Employer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployerAccountRepository implements AccountRepositoryInterface
{

    public function getById(int|string $userId): ?Employer
    {
        return Employer::findByUuid($userId, [
            'employer_id', 'contact_email', 'created_at',
            'company_name', 'company_logo', 'company_description'
        ]);
    }

    public function update(string|int $userId, array $data): Employer
    {
        $employer = Employer::findByUuid($userId);

        if (! $employer) {
            throw new ModelNotFoundException('Tried to updated unknown user with id'.$userId);
        }

        $employer->update([
            'company_name' => $data['name'],
            'company_description' => $data['description']
        ]);

        return $employer;
    }

}
