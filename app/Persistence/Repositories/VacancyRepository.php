<?php

declare(strict_types=1);

namespace App\Persistence\Repositories;

use App\DTO\Vacancy\VacancyDto;
use App\Exceptions\VacancyUpdateException;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Filters\Manual\FilterInterface;
use App\Persistence\Models\Employer;
use App\Persistence\Models\Vacancy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class VacancyRepository implements VacancyRepositoryInterface
{

    public function createAndSync(Employer $employer, VacancyDto $vacancyDto): void
    {
        $vacancy = new Vacancy([
            'title' => $vacancyDto->title,
            'salary' => $vacancyDto->salary,
            'offers' => $vacancyDto->offers,
            'description' => $vacancyDto->description,
            'requirements' => $vacancyDto->requirements,
            'location' => $vacancyDto->location,
            'responsibilities' => $vacancyDto->responsibilities,
            'experience_time' => $vacancyDto->experienceTime,
            'employment_type' => $vacancyDto->employmentType,
            'consider_without_experience' => $vacancyDto->considerWithoutExp
        ]);

        DB::transaction(function () use ($employer, $vacancyDto, $vacancy) {
            $vacancy = $employer->vacancy()->save($vacancy);

            if ($vacancy) {
                $vacancy->techSkills()->sync($vacancyDto->skillSet);
            }
        });
    }

    public function getVacancyById(int $id, array $columns = ['*']): Vacancy
    {
        return Vacancy::with(['techSkills:id,skill_name'])->findOrFail($id, $columns);
    }

    public function updateWithSkills(Vacancy $vacancy, VacancyDto $newData): void
    {
        try {
            $vacancy->update([
                'title' => $newData->title,
                'description' => $newData->description,
                'responsibilities' => $newData->responsibilities,
                'requirements' => $newData->requirements,
                'offers' => $newData->offers,
                'salary' => $newData->salary,
                'location' => $newData->location,
                'experience_time' => $newData->experienceTime,
                'employment_type' => $newData->employmentType,
                'consider_without_experience' => $newData->considerWithoutExp
            ]);

            $vacancy->techSkills()->sync($newData->skillSet);
        } catch (\Throwable $e) {
            throw new VacancyUpdateException($e->getMessage(), $e->getCode());
        }
    }

    public function getFilteredVacancies(FilterInterface $filter, int $paginatePerPage = null): LengthAwarePaginator
    {
        return $this->getFiltered($filter, [
            'employer:id,company_name,company_logo',
            'techSkills:id,skill_name'
        ])->paginate($paginatePerPage, ['title', 'location', 'id', 'salary', 'employer_id']);
    }

    public function getFilteredVacanciesForEmployer(FilterInterface $filter, int $employerId): LengthAwarePaginator
    {
        return $this->getFiltered($filter, ['techSkills:id,skill_name'])
            ->where('employer_id', $employerId)
            ->published()->filter($filter)->paginate(
                3,
                ['title', 'location', 'id', 'salary', 'employer_id']
            );
    }

    public function getLatestPublished(int $number): Collection
    {
        return Vacancy::with(['techSkills:id,skill_name', 'employer:id,employer_id,company_name,company_logo'])
            ->published()
            ->latest()
            ->take($number)
            ->get(['id', 'title', 'employer_id', 'location']);
    }

    protected function getFiltered(FilterInterface $filter, array $withTables): Builder|Vacancy
    {
        return Vacancy::with($withTables)
            ->published()->filter($filter);
    }
}
