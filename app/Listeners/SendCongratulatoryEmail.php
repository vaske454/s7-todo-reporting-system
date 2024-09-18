<?php

namespace App\Listeners;

use App\Events\AllTasksCompleted;
use Illuminate\Support\Facades\Mail;
use App\Mail\CongratulatoryMail;

class SendCongratulatoryEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param AllTasksCompleted $event
     * @return void
     */
    public function handle(AllTasksCompleted $event): void
    {
        $user = $event->user;

        // Send congratulatory email
        Mail::to($user->getAttribute('email'))->send(new CongratulatoryMail($user));
    }
}
