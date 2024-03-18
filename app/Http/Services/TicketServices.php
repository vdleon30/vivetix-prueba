<?php
namespace App\Http\Services;

use App\Models\Event;

interface TicketServices
{
    public function validateAndReservedTickets(Event $event, int $quantity, string $token);
    public function returnReservedTickets(Event $event, $token);
    public function saveOrder(Event $event, $request);

    public function search($request);
}
