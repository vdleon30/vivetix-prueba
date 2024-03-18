<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\LogErrorsTrait;
use App\Shared\Enum\CommonEnum;
use App\Http\Services\EventServices;
use App\Http\Services\TicketServices;
use App\Http\Requests\Tickets\SaveOrderRequest;

class TicketController extends Controller
{
    use LogErrorsTrait;
    protected $viewFolder = "tickets.";
    protected $ticketServices;
    protected $eventServices;
    public function __construct(TicketServices $ticketServices, EventServices $eventServices)
    {
        $this->ticketServices = $ticketServices;
        $this->eventServices = $eventServices;
    }

    public function index(Request $request)
    {
        $tickets = $this->ticketServices->search($request)->paginate(20);
        $events = $this->eventServices->query()->get();

        return view("{$this->viewFolder}.index", ["tickets" => $tickets, "events" => $events, "selectedEvent" => $request->event ?? '']);
    }

    public function sale(Event $event, Request $request)
    {
        return view("{$this->viewFolder}.sales", ["event" => $event]);
    }

    public function saveOrder(SaveOrderRequest $request)
    {
        $token = substr(md5(uniqid(mt_rand(), true)), 0, 8);
        $event = $this->eventServices->getInstance($request->event_id);
        try {
            $this->ticketServices->validateAndReservedTickets($event, (int) $request->quantity, $token);
            $this->ticketServices->saveOrder($event, $request);
        } catch (\Exception $exception) {
            if ($exception->getCode() == Response::HTTP_UNPROCESSABLE_ENTITY) {
                return redirect()->back()->with(CommonEnum::MESSAGE_ERROR, $exception->getMessage());
            }
            $this->ticketServices->returnReservedTickets($event, $token);
            $this->reportError($exception, CommonEnum::LOG_TYPE_ERROR);
            return redirect()->back()->with(CommonEnum::MESSAGE_ERROR, CommonEnum::ERROR_MESSAGE);
        }
        return redirect()->route("tickets.index". ["event" => $request->event_id])->with(CommonEnum::MESSAGE_SUCCESS, CommonEnum::REGISTER_MESSAGE);

    }
}
