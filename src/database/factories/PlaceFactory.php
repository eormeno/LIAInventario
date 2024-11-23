<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;


// /**
//  * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Place>
//  */
class PlaceFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph(),
        ];
    }
}

