<?php

namespace App\Http\Requests\Vacancy;

use App\DTO\Vacancy\VacancyDto;
use App\Enums\Vacancy\EmploymentEnum;
use App\Rules\TechSkillsExistsRule;
use App\Traits\AfterValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class VacancyRequest extends FormRequest
{

    use AfterValidation;

    public function rules(): array
    {
        $rules = [
            'skillset' => ['required', new TechSkillsExistsRule()],
            'title' => ['required', 'string', 'max:100'],
            'salary' => ['numeric', 'between:0,999999'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string'],
            'responsibilities.*' => ['required', 'string'],
            'requirements.*' => ['required', 'string'],
            'offers.*' => ['nullable', 'string'],
            'experience' => ['required', 'numeric'],
            'employment' => [
                'required',
                Rule::enum(EmploymentEnum::class)->only([
                    EmploymentEnum::EMPLOYMENT_OFFICE,
                    EmploymentEnum::EMPLOYMENT_REMOTE,
                    EmploymentEnum::EMPLOYMENT_PART_TIME,
                    EmploymentEnum::EMPLOYMENT_MIXED
                ])
            ],
            'consider' => ['nullable', 'boolean']
        ];

        if (array_key_exists(1, $this->offers ?? [])) {
            foreach ($this->offers as $key => $offer) {
                $rules['offers.'.$key] = 'string';
            }
        }

        return $rules;
    }

    public function makeCastAndMutatorsAfterValidation(array &$data): void
    {
        $this->castFirstOfferToNullIfItIsEmpty($data);
        $this->castConsiderToBool($data);
        $this->castSkillsIdsToInt($data);
        $this->castExperienceToInt($data);
    }

    public function attributes(): array
    {
        return [
            'responsibilities.*' => 'responsibility',
            'requirements.*' => 'requirement',
            'offers' => 'offer',
        ];
    }

    public function getDto(): VacancyDto
    {
        $validated = $this->validated();

        return new VacancyDto(
            title: $validated['title'],
            description: $validated['description'],
            responsibilities: $validated['responsibilities'],
            requirements: $validated['requirements'],
            skillSet: $validated['skillset'],
            location: $validated['location'],
            experienceTime: $validated['experience'],
            employmentType: $validated['employment'],
            considerWithoutExp: $validated['consider'],
            offers: $validated['offers'] ?? [],
            salary: (int)($validated['salary'] ?? 0)
        );
    }

    public function messages(): array
    {
        return [
            'offers.*' => 'This field required when other fields is provided',
        ];
    }

    private function castConsiderToBool(array &$data): void
    {
        $data['consider'] = (bool)$this->consider;
    }

    private function castSkillsIdsToInt(array &$data): void
    {
        if ($this->has('skillset')) {
            $data['skillset'] = Arr::map($this->skillset, function ($skillId) {
                return (int)$skillId;
            });
        }
    }

    private function castExperienceToInt(array &$data): void
    {
        if ($this->has('experience')) {
            $data['experience'] = (int)$this->experience;
        }
    }

    private function castFirstOfferToNullIfItIsEmpty(array &$data): void
    {
        if ($this->offers && $this->offers[0] === null) {
            $data['offers'] = null;
        }
    }

}
