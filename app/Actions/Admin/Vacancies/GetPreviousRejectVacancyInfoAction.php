<?php

declare(strict_types=1);

namespace App\Actions\Admin\Vacancies;

use App\Enums\Actions\AdminActionEnum;
use App\Persistence\Models\AdminAction;
use App\Persistence\Models\Vacancy;
use Illuminate\Database\Eloquent\Builder;

class GetPreviousRejectVacancyInfoAction
{
    public function handle(Vacancy $vacancy): ?object
    {
        $rejectInfo = $vacancy->actionsMadeByAdmin()
            ->where(function (Builder $builder) {
                $builder->where('action_name', AdminActionEnum::REJECT_VACANCY_ACTION)
                    ->orWhere('action_name', AdminActionEnum::DELETE_VACANCY_TEMP_ACTION);
            })
            ->latest('action_performed_at')
            ->first();

        if (! $rejectInfo) {
            return null;
        }

        return $this->prepareData($rejectInfo);
    }

    private function prepareData(AdminAction $action): object
    {
        return (object) [
            'reason' => $action->reason->type,
            'description' => $action->reason->description,
            'comment' => $action->reason->comment,
            'performedAt' => $action->action_performed_at->format('Y-m-d H:i').' '.
                $action->action_performed_at->getTimezone()
        ];
    }
}
