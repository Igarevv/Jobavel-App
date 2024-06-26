<?php

namespace Database\Factories\Persistence\Models;

use App\Enums\Role;
use App\Persistence\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Persistence\Models\User>
 */
class UserFactory extends Factory
{

    protected $model = User::class;

    public function definition(): array
    {
        return [
            'email' => fake()->safeEmail(),
            'password' => Hash::make('password1'),
            'user_id' => Uuid::uuid7()->toString(),
            'is_confirmed' => true,
            'email_confirmed_at' => now(),
        ];
    }

    public function unverified(): Factory|UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_confirmed' => false,
                'email_confirmed_at' => null,
            ];
        });
    }

    public function employeeRole(): UserFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return ['role' => Role::EMPLOYEE->value];
        });
    }

    public function employerRole(): UserFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return ['role' => Role::EMPLOYER->value];
        });
    }

}
