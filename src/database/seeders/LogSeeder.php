<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Log;
use App\Models\User;
use App\Models\Ticket;

class LogSeeder extends Seeder
{
    public function run(): void
    {
        // Generar logs asociados a tickets existentes
        $tickets = Ticket::all();
        foreach ($tickets as $ticket) {
            Log::factory()->count(3)->create([
                'user_id' => User::inRandomOrder()->first()->id,
                'ticket_id' => $ticket->id,
            ]);
        }
    }
}
