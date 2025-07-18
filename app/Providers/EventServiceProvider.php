<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;

class EventServiceProvider extends BaseEventServiceProvider
{
    protected $listen = [
        Registered::class => [SendEmailVerificationNotification::class],
    ];

    public function boot()
    {
        parent::boot();
    }
}
