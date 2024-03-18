<?php

namespace Tests\Feature\App\Repositories;

use Exception;
use Tests\TestCase;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use App\Http\Repositories\TicketRepository;

class TicketRepositoryTest extends TestCase
{
    public function test_validateAndReservedTickets_throws_exception_if_quantity_exceeds_event_quantity()
    {
        $ticketRepository = new TicketRepository(new Ticket());
        $event = new Event();
        $event->quantity = 5;

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("¡Tickets Agotados!");
        $this->expectExceptionCode(Response::HTTP_UNPROCESSABLE_ENTITY);

        $ticketRepository->validateAndReservedTickets($event, 10, 'token');
    }


    public function test_returnReservedTickets_updates_event_quantity_correctly()
    {
        $ticketRepository = new TicketRepository(new Ticket());
        $event = new Event();
        $event->quantity = 5;

        $ticketRepository->returnReservedTickets($event, 'token');

        $this->assertEquals(5, $event->quantity);
    }

    public function test_saveOrder_creates_ticket_with_provided_data()
    {
        $ticketRepository = new TicketRepository(new Ticket());
        $event = Event::factory()->create();
        $request = new \Illuminate\Http\Request();
        $request->merge([
            'client_email' => 'test@example.com',
            'client_name' => 'John Doe',
            'quantity' => $event->quantity,
            "event_id" => $event->id
        ]);
        $file = UploadedFile::fake()->create('proof.pdf');

        $request->files->add(['file' => $file]);

        $ticketRepository->saveOrder($event, $request);

        $this->assertDatabaseHas('tickets', [
            'client_email' => 'test@example.com',
            'client_name' => 'John Doe',
            'quantity' => $event->quantity,
        ]);
    }

}
