<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run()
    {
        // Crear 10 tickets
        $tickets = Ticket::factory(10)->create();

        // Crear logs para cada ticket
        $tickets->each(function ($ticket) {
            Log::factory(3)->create(['ticket_id' => $ticket->id]);
        });
    }
}

