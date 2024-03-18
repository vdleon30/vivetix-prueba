<?php

namespace Tests\Feature\App\Requests;

use Tests\TestCase;
use App\Http\Requests\Events\CreateEventsRequest;

class CreateEventsRequestTest extends TestCase
{
    public function test_validation_rules_for_create_events_request()
    {
        $request = new CreateEventsRequest();

        $rules = $request->rules();

        $this->assertEquals([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date', 'after:' . now()->format('Y-m-d')],
            'quantity' => ['required', 'numeric', 'min:1'],
        ], $rules);
    }
}
