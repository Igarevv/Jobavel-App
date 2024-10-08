<?php

namespace Database\Factories\Persistence\Models;

use App\Enums\EmployerEnum;
use App\Persistence\Models\Employer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Persistence\Models\Employer>
 */
class EmployerFactory extends Factory
{

    protected $model = Employer::class;

    public function definition(): array
    {
        return [
            'company_name' => $this->faker->company(),
            'company_description' => $this->faker->paragraph(1),
            'employer_id' => Uuid::uuid7()->toString(),
            'company_type' => Arr::random(
                [
                    EmployerEnum::COMPANY_TYPE_OUTSTAFF->value,
                    EmployerEnum::COMPANY_TYPE_AGENCY->value,
                    EmployerEnum::COMPANY_TYPE_OUTSOURCE->value,
                    EmployerEnum::COMPANY_TYPE_PRODUCT->value
                ]
            ),
            'company_logo' => 'default_logo.png',
        ];
    }

}
