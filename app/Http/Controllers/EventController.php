<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Event;
use App\Http\Requests\EventRequest;
use App\DataTables\CmsDataTable;
use App\Http\Controllers\Controller;
use App\Services\EventService;
use Illuminate\Support\Facades\Auth;


class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Events';
        $resource = 'event';
        $columns = ['name', 'date & time', 'location', 'status', 'actions'];
        $data = Event::getAllEvents();
        $subRecords = Barangay::getAllBarangays();

        return $dataTable
            ->render('event.index', compact(
                'page_title',
                'resource',
                'columns',
                'data',
                'subRecords',
                'dataTable',
            ));
    }
    
    public function store(EventRequest $request)
    {
        $event = $this->eventService->eventStore($request->validated());

        activity()
            ->performedOn($event)
            ->causedBy(Auth::user())
            ->log('User: ' . Auth::user()->first_name .' '.Auth::user()->last_name . ' created an event.');

        return redirect()
            ->route(Auth::user()->getRoleNames()->first(). '.event.index')
            ->with('success', 'You have successfully created an event: ' . $event->name);
    }

    public function update(EventRequest $request, Event $event)
    {
        $event = $this->eventService->eventUpdate($request->validated(), $event);

        activity()
            ->performedOn($event)
            ->causedBy(Auth::user())
            ->log('User: ' . Auth::user()->first_name .' '.Auth::user()->last_name . ' updated the event: ' . $event->name);

        return redirect()
            ->route(Auth::user()->getRoleNames()->first(). '.event.index')
            ->with('success', 'You have successfully updated an event: ' . $event->name);
    }
    
    public function destroy(Event $event)
    {
        $eventName = $event->name;
        $this->eventService->eventDestroy($event);

        activity()
            ->performedOn($event)
            ->causedBy(Auth::user())
            ->log('User: ' . Auth::user()->first_name .' '.Auth::user()->last_name . ' deleted the event: ' . $eventName);

        return redirect()
            ->route(Auth::user()->getRoleNames()->first(). '.event.index')
            ->with('success', 'You have successfully deleted an event: ' . $eventName);
    }
}