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
            'subject' => $this->faker->sentence,   // Campo corregido de 'title' a 'subject'
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['Pendiente', 'En Proceso', 'Resuelto']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
