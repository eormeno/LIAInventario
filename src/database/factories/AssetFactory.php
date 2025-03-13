<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\Place;
use App\Utils\FakeImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    protected $model = Asset::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word(),
            'codigo_inventario' => $this->faker->unique()->numerify('INV-#####'),
            'codigo_patrimonio' => $this->faker->unique()->numerify('PAT-#####'),
            'detalle' => $this->faker->sentence(),
            'imagen' => FakeImage::generateBase64Image(),
            'tipo' => $this->faker->randomElement(['Tipo 1', 'Tipo 2', 'Tipo 3']),
            'cantidad' => $this->faker->numberBetween(1, 100),
            'alta' => $this->faker->date(),
            'baja' => $this->faker->optional()->date(), // Puede ser null
            'observaciones' => $this->faker->optional()->text(),
            'place_id' => Place::factory(),
        ];
    }
}

