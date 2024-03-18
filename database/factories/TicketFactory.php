<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'client_name' => $this->faker->name,
            'client_email' => $this->faker->unique()->safeEmail,
            'quantity' => $this->faker->numberBetween(1, 10),
            'event_id' => function () {
                return \App\Models\Event::factory()->create()->id;
            },
            'proof' => $this->faker->word . '.pdf', // Ejemplo de nombre de archivo
        ];
    }
}
