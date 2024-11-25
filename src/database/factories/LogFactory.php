<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Ticket;

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
            'estado' => $this->faker->randomElement(['abierto', 'en progreso', 'cerrado']),
            'imagen' => $this->generateBase64Image(),
            'comentario' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function generateBase64Image()
    {
        $imageUrl = 'https://picsum.photos/255/255?random=' . rand(1, 200);
        $image = file_get_contents($imageUrl);
        return 'data:image/jpeg;base64,' . base64_encode($image);
    }
}



