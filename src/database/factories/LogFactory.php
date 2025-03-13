<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ticket;
use App\Utils\FakeImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    public function definition(): array
    {
        // Obtener usuarios existentes o crear uno si no existen
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        // Obtener tickets existentes o crear uno si no existen
        $ticket = Ticket::inRandomOrder()->first() ?? Ticket::factory()->create();

        return [
            'user_id' => $user->id, // Asegurarse de que el user_id está correctamente asignado
            'ticket_id' => $ticket->id, // Asegurarse de que el ticket_id está correctamente asignado
            'estado' => $this->faker->randomElement(['Creado', 'En progreso', 'Cerrado']),
            'imagen' => FakeImage::generateBase64Image(),
            'comentario' => $this->faker->sentence(),
            'created_at' => now(),
        ];
    }
}
