<?php

namespace App\Persistence\Models;

use App\Persistence\Contracts\GetPublicIdentifierForActionInterface;
use App\Persistence\Searcher\Searchers\EmployerSearcher;
use App\Service\Cache\Cache;
use App\Traits\Searchable\Searchable;
use App\Traits\Sortable\Sortable;
use App\Traits\Sortable\VO\SortedValues;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

/**
 * @property string $company_name,
 * @property string $employer_id,
 * @property string $company_description,
 * @property string $company_logo,
 * @property string $company_type
 * @property Carbon $created_at
 * @property string $contact_email
 * @method static Employer|static findOrFail($id, $columns = ['*'])
 * @method static Builder|static sortBy(Builder $builder, SortedValues $sortedValues)
 */
class Employer extends Model implements GetPublicIdentifierForActionInterface
{
    use Searchable;
    use HasFactory;
    use Sortable;

    protected $table = 'employers';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'status',
        'company_name',
        'contact_email',
        'company_description',
        'company_type',
        'company_logo',
        'created_at',
    ];

    protected $hidden = [
        'id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }

    public function techSkills(): HasManyThrough
    {
        return $this->hasManyThrough(VacancySkills::class, Vacancy::class, 'employer_id', 'vacancy_id');
    }

    public function appliedVacancies(): HasManyThrough
    {
        return $this->hasManyThrough(EmployeeVacancy::class, Vacancy::class, 'employer_id', 'vacancy_id');
    }

    public function actionsMadeByAdmin(): MorphMany
    {
        return $this->morphMany(AdminAction::class, 'actionable');
    }

    public function userId(): string
    {
        return $this->user->getUuidKey();
    }

    public function getAccountEmail(): string
    {
        return $this->user->getEmail();
    }

    public function appliedVacanciesForTodayAndMonth(): array
    {
        $applicationsCount = $this->appliedVacancies()
            ->selectRaw(
                'COUNT(CASE WHEN DATE(employee_vacancy.applied_at) = ? THEN 1 END) as today,
                COUNT(CASE WHEN DATE(employee_vacancy.applied_at) BETWEEN ? AND ? THEN 1 END) as month',
                [now()->toDateString(), now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()]
            )->groupBy('vacancies.employer_id')
            ->first(['today', 'month'])
            ?->toArray();

        return [$applicationsCount['today'] ?? 0, $applicationsCount['month'] ?? 0];
    }

    public function topFrequentlySelectedSkills(int $limit): Collection
    {
        return $this->techSkills()
            ->selectRaw('count(vacancy_id) as total, ts.skill_name, ts.id, count(vacancies.id) as vacancy')
            ->join('tech_skills as ts', 'tech_skill_id', '=', 'ts.id')
            ->groupBy('employer_id', 'ts.id')
            ->orderByDesc('total')
            ->take($limit)
            ->get();
    }

    public function scopeByUuid(Builder $builder, string $uuid): Builder
    {
        return $builder->where('employer_id', $uuid);
    }

    public function compareEmails(string $newEmail): bool
    {
        return $this->contact_email === $newEmail;
    }

    public function getUuid(): ?string
    {
        return $this->employer_id;
    }

    public function getFullName(): string
    {
        return $this->company_name;
    }

    public function getIdentifier(): string
    {
        return $this->employer_id;
    }

    public function companyType(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value)
        );
    }

    public static function findByUuid(string $uuid, array $columns = ['*']): static
    {
        return static::where('employer_id', $uuid)->firstOrFail($columns);
    }

    protected function searcher(): string
    {
        return EmployerSearcher::class;
    }

    protected function sortableFields(): array
    {
        return [
            'creation-time' => 'created_at',
            'company' => 'company_name',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Employer $employer) {
            if (! $employer->employer_id) {
                $employer->employer_id = Uuid::uuid7()->toString();
            }
            if (! $employer->company_logo) {
                $employer->company_logo = config('app.default_employer_logo');
            }
        });

        static::saved(function (Employer $employer) {
            Cache::forgetKey('vacancy-employer', $employer->employer_id);
            Cache::forgetKey('logo', $employer->company_logo);
        });
    }

}
