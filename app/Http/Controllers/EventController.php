<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Traits\LogErrorsTrait;
use App\Shared\Enum\CommonEnum;
use App\Http\Services\EventServices;
use App\Http\Requests\Events\CreateEventsRequest;

class EventController extends Controller
{
    use LogErrorsTrait;
    protected $viewFolder = "events.";
    protected $eventServices;

    public function __construct(EventServices $eventServices)
    {
        $this->eventServices = $eventServices;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = $this->eventServices->query()->paginate(20);
        return view("{$this->viewFolder}.index", ["events" => $events]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("{$this->viewFolder}.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEventsRequest $request)
    {
        try {
            $this->eventServices->storeInstance($request->only(Event::BASIC_INFORMATION));
        } catch (\Exception $exception) {
            $this->reportError($exception, CommonEnum::LOG_TYPE_ERROR);
            return redirect()->back()->with(CommonEnum::MESSAGE_ERROR, CommonEnum::ERROR_MESSAGE);
        }
        return redirect()->route("events.index")->with(CommonEnum::MESSAGE_SUCCESS, CommonEnum::REGISTER_MESSAGE);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = $this->eventServices->getInstance($id);
        return view("{$this->viewFolder}.edit", compact("event"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $information = $request->only(Event::BASIC_INFORMATION);
            $information[] = Event::STATUS;
            $this->eventServices->updateInstance($id, $information);
        } catch (\Exception $exception) {
            $this->reportError($exception, CommonEnum::LOG_TYPE_ERROR);
            return redirect()->back()->with(CommonEnum::MESSAGE_ERROR, CommonEnum::ERROR_MESSAGE);
        }
        return redirect()->route("events.index")->with(CommonEnum::MESSAGE_SUCCESS, CommonEnum::UPDATE_MESSAGE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $event = $this->eventServices->getInstance($id);
            $event->delete();
        } catch (\Exception $exception) {
            $this->reportError($exception, CommonEnum::LOG_TYPE_ERROR);
            return redirect()->back()->with(CommonEnum::MESSAGE_ERROR, CommonEnum::ERROR_MESSAGE);
        }
        return redirect()->route("events.index")->with(CommonEnum::MESSAGE_SUCCESS, CommonEnum::UPDATE_MESSAGE);
    }
}
