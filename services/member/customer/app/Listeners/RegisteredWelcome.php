<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WelcomeNotification;

class RegisteredWelcome implements ShouldQueue
{
    use InteractsWithQueue;

    /*
    public $connection = 'redis';
    public $queue = 'auth';
    public $delay = 30;
    */

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
    public function handle(Registered $event): void
    {
        Notification::send($event->user, new WelcomeNotification($event->user));
    }
}
