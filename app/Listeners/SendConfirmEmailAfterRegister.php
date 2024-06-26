<?php

namespace App\Listeners;

use App\Mail\ConfirmEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Mail;

class SendConfirmEmailAfterRegister
{

    public function handle(Registered $event): void
    {
        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail(
            )) {
            Mail::to($event->user)->send(new ConfirmEmail($event->user));
        }
    }

}
