<?php

namespace Tests\Feature\App\Controller;

use App\Http\Controllers\EventController;
use App\Http\Requests\Events\CreateEventsRequest;
use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Http\Services\EventServices;


class EventControllerTest extends TestCase
{

    public function test_index_method_returns_view_with_events(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/events');

        $response->assertOk();
    }

    public function test_store_method_redirects_to_index_on_success()
    {

        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/events', [
                'title' => 'Event Title',
                'description' => 'Event Description',
                'date' => (new \Carbon\Carbon('tomorrow'))->format("Y-m-d"),
                'quantity' => 100,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/events');
        $this->assertDatabaseHas('events', ['title' => 'Event Title', 'quantity' => 100]);

    }


    public function test_update_method_redirects_to_index_on_success()
    {

        $user = User::factory()->create();
        $event = Event::factory()->create();
        $response = $this
            ->actingAs($user)
            ->put("events/{$event->id}", [
                'title' => 'Event Title',
                'description' => 'Event Description',
                'date' => (new \Carbon\Carbon('tomorrow'))->format("Y-m-d"),
                'quantity' => 100,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/events');
        $event->refresh();

        $this->assertSame('Event Title', $event->title);
        $this->assertSame((new \Carbon\Carbon('tomorrow'))->format("Y-m-d"), $event->date);

    }

    public function test_delete_method_redirects_to_index_on_success()
    {

        $user = User::factory()->create();
        $event = Event::factory()->create();
        $response = $this
            ->actingAs($user)
            ->delete("events/{$event->id}");

        Event::find($event->id);

        $response->assertSessionHasNoErrors()
            ->assertRedirect('/events');
        $this->assertDatabaseMissing('events', ['id' => $event->id]);

    }


    public function test_store_method_redirects_to_index_on_failed()
    {
        $eventService = \Mockery::mock(EventServices::class);
        $request = new CreateEventsRequest();
        $request->merge([
            'title' => 'Event Title',
            'description' => 'Event Description',
            'date' => (new \Carbon\Carbon('tomorrow'))->format("Y-m-d"),
            'quantity' => 100,
        ]);
        $eventService->shouldReceive('storeInstance')->with($request)
            ->andThrowExceptions([new \Exception("message", 404)]);

        $controller = new EventController($eventService);


        $controller->store($request);
        $this->assertDatabaseHas('events', ['title' => 'Event Title', 'quantity' => 100]);
    }

    public function test_edit_method_redirects_success(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get("/events/{$event->id}/edit");

        $response->assertOk();
    }

    public function test_create_method_redirects_success(): void
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get("/events/create");

        $response->assertOk();
    }

    public function test_update_method_redirects_to_index_on_failed()
    {

        $event = Event::factory()->create();
        $token = substr(md5(uniqid(mt_rand(), true)), 0, 8);
        $request = new CreateEventsRequest();
        $request->merge([
            'title' => 'Event Title',
            'description' => 'Event Description',
            'date' => (new \Carbon\Carbon('tomorrow'))->format("Y-m-d"),
            'quantity' => 100,
        ]);
        $eventService = \Mockery::mock(EventServices::class);
        $eventService->shouldReceive('updateInstance')->with($event->id,$request)
            ->andThrowExceptions([new \Exception("message", 404)]);

        $controller = new EventController($eventService);


        $controller->update($request, $event->id);
        $this->assertDatabaseHas('events', ['title' => $event->title, 'quantity' => $event->quantity]);
    }

    public function test_destroy_method_redirects_to_index_on_failed()
    {

        $event = Event::factory()->create();
        $token = substr(md5(uniqid(mt_rand(), true)), 0, 8);

        $eventService = \Mockery::mock(EventServices::class);
        $eventService->shouldReceive('getInstance')->with($event, (int) ($event->quantity + 20), $token)
            ->andThrowExceptions([new \Exception("message", 404)]);

        $controller = new EventController($eventService);
        $controller->destroy($event->id);
        $this->assertDatabaseHas('events', ['title' => $event->title, 'quantity' => $event->quantity]);
    }




}
