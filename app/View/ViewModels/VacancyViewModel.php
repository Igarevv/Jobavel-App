<?php

declare(strict_types=1);

namespace App\View\ViewModels;

use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Models\Vacancy;
use App\Service\Cache\Cache;
use App\Service\Employer\Storage\EmployerLogoService;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Collection;

class VacancyViewModel
{
    public function __construct(
        private Cache $cache,
        private VacancyRepositoryInterface $vacancyRepository,
        private EmployerLogoService $employerLogoService,
    ) {
    }

    public function vacancy(int $vacancy): Vacancy
    {
        $cacheKey = $this->cache->getCacheKey('vacancy', $vacancy);

        return $this->cache->repository()->remember($cacheKey, CarbonInterval::month()->totalSeconds,
            function () use ($vacancy) {
                return $this->vacancyRepository->getVacancyById($vacancy);
            });
    }

    public function vacancyEmployerData(Vacancy $vacancy): object
    {
        $cacheKey = $this->cache->getCacheKey('vacancy-employer', $vacancy->id);

        return $this->cache->repository()->remember($cacheKey, CarbonInterval::month()->totalSeconds,
            function () use ($vacancy) {
                $employer = $vacancy->employer;

                $companyLogoUrl = $this->employerLogoService->getImageUrlByEmployer($employer);

                return (object) [
                    'company' => $employer->company_name,
                    'description' => $employer->company_description,
                    'logo' => $companyLogoUrl,
                    'email' => $employer->contact_email,
                    'type' => $employer->company_type
                ];
            });
    }

    public function getLatestPublishedVacancies(int $howMany): Collection
    {
        return $this->vacancyRepository->getLatestPublished($howMany);
    }

}