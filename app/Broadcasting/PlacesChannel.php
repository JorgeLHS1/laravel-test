<?php

namespace App\Broadcasting;

use App\User;
use Illuminate\Support\Facades\Auth;

class PlacesChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @return array|bool
     */
    public function join()
    {
        if (Auth::check()) {
            return true;
        }

        return false;
    }
}
