<?php

namespace App\Listeners;

use App\Events\EmailVerificationlinkWasClicked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerification
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
     * @param  EmailVerificationlinkWasClicked  $event
     * @return void
     */
    public function handle(EmailVerificationlinkWasClicked $event)
    {
        $event->user->verify($event->user->id, $event->user->email, $event->user->token);
    }
}
