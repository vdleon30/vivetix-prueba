<?php


namespace App\Http\Repositories;

use App\Models\Ticket;
use App\Shared\Enum\TicketEnum;
use Exception;
use App\Models\Event;
use Illuminate\Http\Response;
use App\Http\Services\TicketServices;

class TicketRepository extends Repository implements TicketServices
{
    protected $model;
    public function __construct(Ticket $model)
    {
        $this->model = $model;
        parent::__construct($model);
    } //end __construct()

    public function validateAndReservedTickets(Event $event, int $quantity, string $token)
    {
        if($event->quantity < $quantity ){
            throw new Exception("¡Tickets Agotados!", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $event->update([
            "quantity" => $event->quantity - $quantity
        ]);
        session([$token => $quantity]);
    }


    public function returnReservedTickets(Event $event, $token)
    {
        $quantity = session($token);
        $event->update([
            "quantity" => $event->quantity + $quantity
        ]);

    }
    public function saveOrder(Event $event, $request)
    {
        $file = $request->file('file');
        $fileName =  $file->store('assets/files/tickets/proofs', 'uploads');
        $event->tickets()->create([
            TicketEnum::CLIENT_EMAIL => $request->client_email,
            TicketEnum::CLIENT_NAME => $request->client_name,
            TicketEnum::QUANTITY => $request->quantity,
            TicketEnum::PROOF => $fileName,
        ]);
    }

    public function search($request)
    {
        return $this->model::events($request->event);
    }

} //end class
