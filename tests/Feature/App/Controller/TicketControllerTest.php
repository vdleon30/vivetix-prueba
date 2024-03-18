<?php

namespace Tests\Feature\App\Controller;

use App\Http\Controllers\TicketController;
use App\Http\Requests\Tickets\SaveOrderRequest;
use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\UploadedFile;
use App\Http\Services\EventServices;
use App\Http\Services\TicketServices;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/tickets');
        $response->assertStatus(200);
    }

    public function test_sale()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $response = $this->actingAs($user)->get("/tickets/sale/{$event->id}");
        $response->assertStatus(200);
    }

    public function test_saveOrderFailed()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();

        $request = new \Illuminate\Http\Request();
        $request->merge([
            'client_email' => 'test@example.com',
            'client_name' => 'John Doe',
            'quantity' => $event->quantity + 20,
            "event_id" => $event->id
        ]);
        $file = UploadedFile::fake()->create('proof.pdf');

        $request->files->add(['file' => $file]);

        $response = $this->actingAs($user)->post('/tickets/saveOrder', $request->all());
        $response
            ->assertSessionDoesntHaveErrors();

        $response->assertStatus(302); // Redirection status
    }

    public function test_saveOrderFailed_event()
    {
        $event = Event::factory()->create();
        $token = substr(md5(uniqid(mt_rand(), true)), 0, 8);

        $eventService = \Mockery::mock(EventServices::class);
        $ticketService = \Mockery::mock(TicketServices::class);
        $eventService->shouldReceive('getInstance')
            ->once()
            ->andReturn($event);
        $ticketService->shouldReceive('validateAndReservedTickets')->with($event, (int) ($event->quantity + 20), $token)
            ->andThrowExceptions([new \Exception("message", 404)]);
        $ticketService->shouldReceive('returnReservedTickets')
            ->once()
            ->andReturn($event);
        $controller = new TicketController($ticketService, $eventService);

        $request = new SaveOrderRequest();
        $request->merge([
            'client_email' => 'test@example.com',
            'client_name' => 'John Doe',
            'quantity' => (int) ($event->quantity + 20),
            "event_id" => $event->id + 1
        ]);
        $file = UploadedFile::fake()->create('proof.pdf');

        $request->files->add(['file' => $file]);
        $controller->saveOrder($request);
    }

    public function test_saveOrder()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        $request = new \Illuminate\Http\Request();
        $request->merge([
            'client_email' => 'test@example.com',
            'client_name' => 'John Doe',
            'quantity' => $event->quantity,
            "event_id" => $event->id
        ]);
        $file = UploadedFile::fake()->create('proof.pdf');

        $request->files->add(['file' => $file]);
        $response = $this->actingAs($user)->post('/tickets/saveOrder', $request->all());
        $response->assertStatus(302); // Redirection status
        $this->assertDatabaseHas('tickets', ['event_id' => $event->id, 'quantity' => $event->quantity]);
        $response->assertRedirect('/tickets');
    }
}
