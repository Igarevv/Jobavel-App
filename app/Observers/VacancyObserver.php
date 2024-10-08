<?php

namespace App\Observers;

use App\Enums\Vacancy\VacancyStatusEnum;
use App\Persistence\Models\Vacancy;
use App\Service\Cache\Cache;

class VacancyObserver
{
    public function creating(Vacancy $vacancy): void
    {
        if (! $vacancy->created_at) {
            $vacancy->created_at = now();
        }
    }

    public function updated(Vacancy $vacancy): void
    {
        Cache::forgetKey('vacancy', $vacancy->id);
        Cache::forgetKey('vacancies-published', $vacancy->employer()->first()?->employer_id);
    }

    public function saved(Vacancy $vacancy): void
    {
        Cache::forgetKey('vacancy', $vacancy->id);
        Cache::forgetKey('vacancies-published', $vacancy->employer()->first()?->employer_id);
    }

    public function deleted(Vacancy $vacancy): void
    {
        $vacancy->status = VacancyStatusEnum::TRASHED;

        Cache::forgetKey('vacancy', $vacancy->id);

        Cache::forgetKey('vacancies-published', $vacancy->employer()->first()?->employer_id);
    }

    public function restored(Vacancy $vacancy): void
    {
        $vacancy->status = VacancyStatusEnum::NOT_PUBLISHED;

        $vacancy->save();
    }
}
