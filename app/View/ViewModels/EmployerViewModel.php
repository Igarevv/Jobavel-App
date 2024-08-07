<?php

declare(strict_types=1);

namespace App\View\ViewModels;

use App\Persistence\Models\Employer;
use App\Persistence\Models\VacancySkills;
use Illuminate\Support\Collection;

class EmployerViewModel
{
    public function prepareStatistics(Employer $employer): ?object
    {
        $topSkills = $employer->topFrequentlySelectedSkills(3) ?: null;

        if ($topSkills) {
            $topSkills = (object) [
                'ids' => $this->skillIdsInRaw($topSkills),
                'names' => $this->skillNamesInRaw($topSkills)
            ];
        }

        return (object) [
            'totalVacancies' => $employer->vacancy()->count(),
            'skills' => $topSkills,
        ];
    }

    protected function skillIdsInRaw(Collection $vacancySkills): string
    {
        return $vacancySkills->implode(function (VacancySkills $vacancySkills) {
            return $vacancySkills->id;
        }, ',');
    }

    protected function skillNamesInRaw(Collection $vacancySkills): string
    {
        return $vacancySkills->implode(function (VacancySkills $vacancySkills) {
            return $vacancySkills->skill_name;
        }, ', ');
    }

}