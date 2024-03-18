<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Ticket;
use App\Models\Event;

class TicketTest extends TestCase
{
    public function test_event_relation()
    {
        $ticket = new Ticket();
        $relation = $ticket->event();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
        $this->assertEquals('event_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getOwnerKeyName());
    }

    public function test_scope_events()
    {
        $ticket = new Ticket();
        $query = Ticket::query();

        // Without ID
        $result1 = $ticket->scopeEvents(Ticket::query(), null)->toSql();
        $expected1 = $query->toSql();
        $this->assertEquals($expected1, $result1);

        $ticket = new Ticket();
        // With ID
        $id = 1;
        $result2 = $ticket->scopeEvents(Ticket::query(), $id)->toSql();
        $expected2 = $query->where('event_id', $id)->toSql();
        $this->assertEquals($expected2, $result2);
    }
}
