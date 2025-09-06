<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\User;
use App\Mail\EventMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $eventId;

    public function __construct(int $eventId)
    {
        $this->eventId = $eventId;
    }

    public function handle(): void
    {
        $event = Event::with('barangay')
            ->find($this->eventId);

        if (!$event) {
            return;
        }
        
        // User::where('barangay_id', $event->barangay_id)
        //     ->whereNotNull('email')
        //     ->select('id', 'name', 'email', 'barangay_id')
        //     ->chunk(200, function ($users) use ($event) {
        //         foreach ($users as $user) {
        //             Mail::to($user->email)->queue(new EventMail($event, $user));
        //         }
        //     });

        User::select('id', 'first_name', 'middle_name', 'last_name', 'email')
            ->whereNotNull('email')
            ->chunk(200, function ($users) use ($event) {
                foreach ($users as $user) {
                    Mail::to($user->email)->queue(new EventMail($event, $user));
                }
            });
    }
}

