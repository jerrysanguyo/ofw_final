<?php

namespace App\Services;

use App\Models\Event;

class EventService
{
    public function eventStore(array $data)
    {
        $event = Event::create([
                'name'          => $data['name'],
                'status'        => 'created',
                'venue'         => $data['venue'],
                'remarks'       => $data['remarks'],
                'barangay_id'   => $data['barangay'],
                'time'          => $data['time'],
                'date'          => $data['date'], 
        ]);

        return $event ?: null;
    }

    public function eventUpdate(array $data, $event): Event
    {
        $event->update(
            [
                'name'          => $data['name'],
                'status'        => $data['status'],
                'venue'         => $data['venue'],
                'remarks'       => $data['remarks'],
                'barangay_id'   => $data['barangay'],
                'time'          => $data['time'],
                'date'          => $data['date'], 
            ]
        );

        return $event->fresh();
    }

    public function eventDestroy(Event $event): ?Event
    {
        if ($event->delete()) {
            return $event;
        }

        return null;
    }
}
