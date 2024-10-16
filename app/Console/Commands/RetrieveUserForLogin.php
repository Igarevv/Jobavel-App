<?php

namespace App\Console\Commands;

use App\Persistence\Models\User;
use Database\Factories\Persistence\Models\UserFactory;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Throwable;

class RetrieveUserForLogin extends Command
{

    protected $signature = 'test:give-user {role?}';

    protected $description = 'Simple way quickly retrieve registered user for login';

    public function handle(): void
    {
        $role = $this->argument('role');

        if (! in_array($role, [0, 1])) {
            $role = $this->choice(
                question: 'Which type of user do you want to retrieve?',
                choices: [User::EMPLOYEE, User::EMPLOYER],
                attempts: 3
            );
        } else {
            $role = $role == 0 ? User::EMPLOYEE : User::EMPLOYER;
        }

        try {
            $user = User::role($role)->inRandomOrder()->first(['email']);

            if (! $user) {
                $this->error("User with role {$role} not found.");
                return;
            }

            $this->info('Success. Your test user:');

            $this->table(['Email', 'Password'], [[$user->email, UserFactory::TEST_PASSWORD]]);

            $this->newLine();
        } catch (Throwable $throwable) {
            $this->error('Something went wrong when retrieve user from db: ', $throwable->getMessage());
        }
    }

}
