<?php

declare(strict_types=1);

namespace App\DTO\Vacancy;

use App\Http\Requests\Vacancy\ApplyRequest;
use App\Persistence\Models\Employee;
use App\Persistence\Models\Vacancy;

readonly final class AppliedVacancyDto
{
    public function __construct(
        public Vacancy $vacancy,
        public Employee $employee,
        public string $contactEmail,
        public bool $useCvFile = false
    ) {
    }

    public static function fromRequestWithEntities(
        ApplyRequest $request,
        Vacancy $vacancy,
        Employee $employee
    ): AppliedVacancyDto {
        $data = $request->validated();

        return new AppliedVacancyDto(
            vacancy: $vacancy,
            employee: $employee,
            contactEmail: $data['useCurrentEmail'] ? $employee->email : $data['contactEmail'],
            useCvFile: $data['cvType']
        );
    }
}
