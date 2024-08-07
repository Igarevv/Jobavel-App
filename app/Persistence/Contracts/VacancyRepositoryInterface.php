<?php

namespace App\Persistence\Contracts;

use App\DTO\Vacancy\VacancyDto;
use App\Persistence\Filters\Manual\FilterInterface;
use App\Persistence\Models\Employer;
use App\Persistence\Models\Vacancy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface VacancyRepositoryInterface
{

    public function createAndSync(Employer $employer, VacancyDto $vacancyDto): void;

    public function getVacancyById(int $id): Vacancy;

    public function updateWithSkills(Vacancy $vacancy, VacancyDto $newData): void;

    public function getFilteredVacancies(FilterInterface $filter, ?int $paginatePerPage = null): LengthAwarePaginator;

    public function getFilteredVacanciesForEmployer(FilterInterface $filter, int $employerId): LengthAwarePaginator;

    public function getLatestPublished(int $number): Collection;
}
