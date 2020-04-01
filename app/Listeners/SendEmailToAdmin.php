<?php

namespace App\Listeners;

use App\Events\RegisteredUser;
use App\Mail\PostRegisteredUserEmail;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailToAdmin
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
     * @param  RegisteredUser  $event
     * @return void
     */
    public function handle(RegisteredUser $event)
    {
        try{
            Log::info($event->user());
            Mail::to('jorge_lhs@live.com')->send(new PostRegisteredUserEmail($event->user()));
        } catch(Exception $e) {
            report($e);
        }


    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\RegiteredUser  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(RegisteredUser $event, $exception)
    {
        Log::error("Não foi possível enviar email de novo usuário para o administrador: {$event->id} - Nome: {$event->name} - Email: {$event->email}", ['Exception' => $exception]);
    }
}
