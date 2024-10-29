<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class PlaceSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Place::factory()->count(3)->create();
    }
}