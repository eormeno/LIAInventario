<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Log;
use App\Models\User;
use App\Models\Asset;
use App\Models\Place;
use Faker\Factory as Faker;

class TicketSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $ticket = Ticket::create([
                'subject' => $faker->sentence,
                'created_by' => User::inRandomOrder()->first()->id,
                'asset_id' => Asset::inRandomOrder()->first()->id,
                'area' => $faker->randomElement(['Software','Hardware','TI','Administrativa']),
            ]);

            Log::create([
                'user_id' => $ticket->created_by,
                'ticket_id' => $ticket->id,
                'estado' => 'Creado',
                'comentario' => 'Ticket creado automáticamente.',
                'created_at' => now(),
            ]);
        }
    }
}


