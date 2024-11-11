<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder {
    public function run(): void {
        fake()->seed(10);   // Esto es para generar siempre los mismos datos
        $this->call(PermissionsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(AssetSeeder::class);
        $this->call(PlaceSeeder::class);

        $this->call(LogSeeder::class);
    }
}
