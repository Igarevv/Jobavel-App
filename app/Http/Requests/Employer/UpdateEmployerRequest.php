<?php

namespace App\Http\Requests\Employer;

use App\DTO\Employer\EmployerPersonalInfoDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployerRequest extends FormRequest
{

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'email' => [
                'sometimes',
                'email',
                Rule::unique('employers', 'contact_email')->ignore($userId, 'user_id'),
                Rule::unique('users')->ignore($userId)
            ],
            'description' => ['sometimes', 'nullable', 'string'],
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('employers', 'company_name')->ignore($userId, 'user_id')
            ]
        ];
    }

    public function getDto(): EmployerPersonalInfoDto
    {
        return new EmployerPersonalInfoDto(
            contactEmail: $this->get('email'),
            description: $this->get('description'),
            companyName: $this->get('name')
        );
    }
}
