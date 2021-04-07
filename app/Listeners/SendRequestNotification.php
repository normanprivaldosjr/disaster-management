<?php

namespace App\Listeners;

use App\Events\NewRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRequestNotification
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
     * @param  NewRequest  $event
     * @return void
     */
    public function handle(NewRequest $event)
    {
        //
    }
}
