<?php

namespace App\Listeners;

use App\Models\UserInformation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserInformation implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        // Retrieve the registered user
        $user = $event->user;

        // Create an empty user information record
        UserInformation::create([
            'email' => $user->email,
            // Other fields remain empty
        ]);
    }
}
