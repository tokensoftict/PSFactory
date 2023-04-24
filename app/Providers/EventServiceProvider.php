<?php

namespace App\Providers;

use App\Events\CompletePuchaseOrderEvent;
use App\Events\InvoicePaidEvent;
use App\Events\MaterialApprovedEvent;
use App\Events\MaterialRequestEvent;
use App\Listeners\CompletePuchaseOrderListener;
use App\Listeners\InvoicePaidEventListener;
use App\Listeners\MaterialRequestEventListener;
use App\Listeners\RemoveMaterial;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CompletePuchaseOrderEvent::class => [
            CompletePuchaseOrderListener::class
        ],
        MaterialRequestEvent::class => [
            MaterialRequestEventListener::class
        ],
        MaterialApprovedEvent::class => [
            RemoveMaterial::class
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

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
