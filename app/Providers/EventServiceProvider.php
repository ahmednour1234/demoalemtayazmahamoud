<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\TaskAssigned::class => [
        \App\Listeners\SendTaskAssignedNotification::class,
    ],
    \App\Events\TaskOverdue::class => [
        \App\Listeners\SendTaskOverdueNotification::class,
    ],
    \App\Events\ApprovalRequested::class => [
        \App\Listeners\SendApprovalRequestedNotification::class,
    ],
    \App\Events\ApprovalDecided::class => [
        \App\Listeners\SendApprovalDecidedNotification::class,
    ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
