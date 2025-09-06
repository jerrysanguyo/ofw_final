<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class EventMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Event $event;
    public User $user;

    public function __construct(Event $event, User $user)
    {
        $this->event = $event;
        $this->user  = $user;
    }

    public function envelope(): Envelope
    {
        $date = Carbon::parse($this->event->date)->format('F j, Y');
        return new Envelope(
            subject: "New Barangay Event: {$this->event->name} ({$date})"
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.event',
            with: [
                'userName' => trim($this->user->first_name . ' ' . ($this->user->middle_name ?? '') . ' ' . $this->user->last_name),
                'eventName'    => $this->event->name,
                'venue'        => $this->event->venue,
                'remarks'      => $this->event->remarks,
                'barangayName' => optional($this->event->barangay)->name ?? 'your barangay',
                'dateStr'      => Carbon::parse($this->event->date)->format('F j, Y'),
                'timeStr'      => $this->event->time,
                'year'         => now()->year,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}