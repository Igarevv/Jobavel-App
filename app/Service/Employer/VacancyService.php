<?php

declare(strict_types=1);

namespace App\Service\Employer;

use App\DTO\VacancyDto;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Models\Employer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VacancyService
{

    public function __construct(
        protected VacancyRepositoryInterface $vacancyRepository
    ) {}

    public function create(array $input): void
    {
        $vacancy = $this->createDto($input);

        $employerId = $this->getGenericIdOfEmployer($input['employer_id']);

        $vacancy->linkEmployerToVacancy($employerId);

        $this->vacancyRepository->createAndSync($vacancy);
    }

    protected function createDto(array $input): VacancyDto
    {
        return new VacancyDto(
            title: $input['title'],
            description: $input['description'],
            responsibilities: $input['responsibilities'],
            requirements: $input['requirements'],
            skillSet: $input['skillset'],
            offers: $input['offers'] ?? [],
            salary: (int) ($input['salary'] ?? 0)
        );
    }

    protected function getGenericIdOfEmployer(string $employerUuid): int
    {
        $employer_id = Employer::query()
            ->where('employer_id', $employerUuid)
            ->pluck('id')
            ->first();

        if ( ! $employer_id) {
            throw new ModelNotFoundException("Employer model with public id: $employerUuid not found");
        }

        return $employer_id;
    }

}