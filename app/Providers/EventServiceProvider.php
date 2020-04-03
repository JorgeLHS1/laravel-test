<?php

namespace App\Providers;

use App\Event\UserRegistered;
use App\Events\RegisteredUser;
use App\Events\SearchedPlaces;
use App\Listeners\SendEmailToAdmin;
use App\Listeners\SendQuerySearched;
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
        RegisteredUser::class => [
            SendEmailToAdmin::class,
        ],
        SearchedPlaces::class => [
            SendQuerySearched::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
