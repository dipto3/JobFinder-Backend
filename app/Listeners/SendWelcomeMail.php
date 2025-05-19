<?php
namespace App\Listeners;

use App\Events\WelcomeMailEvent;
use App\Mail\WelcomeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMail implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */

    /**
     * Handle the event.
     */
    public function handle(WelcomeMailEvent $event): void
    {
        $user = $event->user;

        if (! $user) {

            \Log::error('test');
            return;
        }
        Mail::to($user->email)->send(new WelcomeMail($user));

    }
}
