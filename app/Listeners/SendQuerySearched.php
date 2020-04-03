<?php

namespace App\Listeners;

use App\Events\SearchedPlaces;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendQuerySearched
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SearchedPlaces  $event
     * @return void
     */
    public function handle(SearchedPlaces $event)
    {
        Log::info("Query consultada: {$event->query}");
    }
}
