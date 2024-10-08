<?php

namespace App\Providers;

use App\Events\AdminUpdateEmail;
use App\Events\EmployerUpdated;
use App\Events\JobFailedInAdminPanel;
use App\Events\NewAdminCreated;
use App\Events\UserAccountRestored;
use App\Events\UserBanned;
use App\Events\UserDeletedTemporarily;
use App\Events\VacancyDeletedPermanentlyByAdmin;
use App\Listeners\AuthEventSubscriber;
use App\Listeners\CodeSendingOnEmployerUpdate;
use App\Listeners\SendEmailAboutFailedJobToSuperAdmin;
use App\Listeners\SendEmailAboutPermanentDeletionOfVacancy;
use App\Listeners\SendEmailToAdminToConfirmEmailChange;
use App\Listeners\SendEmailToBannedUser;
use App\Listeners\SendEmailToNewAdminWithTempPassword;
use App\Listeners\SendEmailToUserWhoWantsToRestoreAccount;
use App\Listeners\SendEmailWhenUserDeleted;
use App\Listeners\SuccessfulAdminLogin;
use App\Listeners\SuccessfulUserLogin;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Login::class => [
            SuccessfulUserLogin::class,
            SuccessfulAdminLogin::class
        ],
        EmployerUpdated::class => [
            CodeSendingOnEmployerUpdate::class
        ],
        JobFailedInAdminPanel::class => [
            SendEmailAboutFailedJobToSuperAdmin::class
        ],
        UserDeletedTemporarily::class => [
            SendEmailWhenUserDeleted::class
        ],
        UserAccountRestored::class => [
            SendEmailToUserWhoWantsToRestoreAccount::class
        ],
        NewAdminCreated::class => [
            SendEmailToNewAdminWithTempPassword::class
        ],
        AdminUpdateEmail::class => [
            SendEmailToAdminToConfirmEmailChange::class
        ],
        VacancyDeletedPermanentlyByAdmin::class => [
            SendEmailAboutPermanentDeletionOfVacancy::class
        ],
        UserBanned::class => [
            SendEmailToBannedUser::class
        ]
    ];

    protected $subscribe = [
        AuthEventSubscriber::class
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

}
