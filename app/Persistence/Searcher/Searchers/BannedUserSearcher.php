<?php

declare(strict_types=1);

namespace App\Persistence\Searcher\Searchers;

use App\Enums\Admin\AdminBannedSearchEnum;
use App\Persistence\Searcher\BaseSearcher;
use App\Traits\Searchable\SearchDtoInterface;
use Illuminate\Database\Eloquent\Builder;

class BannedUserSearcher extends BaseSearcher
{

    public function apply(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->when(
            value: $searchDto->getSearchBy() === AdminBannedSearchEnum::ID,
            callback: fn(Builder $builder) => $this->applySearchByEmployerId($builder, $searchDto)
        );
    }

    private function applySearchByEmployerId(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->where($searchDto->getSearchBy()->toDbField(), $searchDto->getSearchable());
    }
}