<?php

namespace App\Providers;

use App\Events\EmployerUpdated;
use App\Listeners\AuthEventSubscriber;
use App\Listeners\CodeSendingOnEmployerUpdate;
use App\Listeners\SuccessfulLogin;
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
            SuccessfulLogin::class,
        ],
        EmployerUpdated::class => [
            CodeSendingOnEmployerUpdate::class
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
