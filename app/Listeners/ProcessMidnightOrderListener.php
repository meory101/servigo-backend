<?php

namespace App\Listeners;

use App\Events\MidnightOrderEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessMidnightOrderListener
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
     */
    public function handle(MidnightOrderEvent $event): void
    {
        //
    }
}
