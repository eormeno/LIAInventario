<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class PlaceSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Place::factory()->count(3)->create();
    }
}