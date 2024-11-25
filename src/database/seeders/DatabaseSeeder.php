<?php

// namespace Database\Seeders;

// use App\Models\LogSeeder;
// use App\Models\User;
// use App\Models\Place;
// use Illuminate\Database\Seeder;


// class DatabaseSeeder extends Seeder {
//     public function run(): void {
//         fake()->seed(10);   // Esto es para generar siempre los mismos datos
//         $this->call(PermissionsSeeder::class);
//         $this->call(AssetSeeder::class);
//         $this->call(PlaceSeeder::class);
//         $this->call(UsersSeeder::class);
//         $this->call(TicketSeeder::class);
//         $this->call(LogSeeder::class);
        

//     }
// }

namespace Database\Seeders;

use Illuminate\Database\Seeder;


use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Configura una semilla para generar datos consistentes
        $faker = Faker::create();
        $faker->seed(10);

        // Ejecuta los seeders en el orden correcto
        $this->call([
            PermissionsSeeder::class, // Primero los permisos y roles
            UsersSeeder::class,       // Luego los usuarios
            PlaceSeeder::class,       // Lugares
            AssetSeeder::class,       // Activos
            TicketSeeder::class,      // Tickets
            LogSeeder::class,         // Logs
        ]);
    }
}

