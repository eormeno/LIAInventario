<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $users =  User::all();
        return [
            'user_id' => $users->random()->id,
            //'ticket_id' => $tickets->random()->id,

            'estado' => $this->faker->randomElement(['abierto', 'en progreso', 'cerrado']),
            'imagen' => $this->generateBase64Image(), 
            'comentario' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
    
    private function generateBase64Image()
    {
        // Generar una imagen de 255x255
        $imageUrl = 'https://picsum.photos/255/255?random=' . rand(1, 200);
        
        // Obtener el contenido de la imagen
        $image = file_get_contents($imageUrl);
        
        // Codificar la imagen en Base64
        return 'data:image/jpeg;base64,' . base64_encode($image);
    }
}
