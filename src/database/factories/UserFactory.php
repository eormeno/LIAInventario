<?php

namespace Database\Factories;

use App\Utils\FakeUtils;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $env_fake_users_password = env('FAKE_USERS_PASSWORD');
        $fake_first = fake()->firstName();
        $fake_last = fake()->lastName();
        $fake_name = "$fake_first $fake_last";
        $fake_email = FakeUtils::email($fake_first, $fake_last);

        return [
            'name' => $fake_name,
            'email' => $fake_email,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make($env_fake_users_password),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
            'registro' => $this->faker->unique()->regexify('E[0-9]{2}-[0-9]{3}'),
            'apellidos' => $fake_last,
            'nombres' => $fake_first,
            'cuil' => $this->faker->unique()->numerify('##-########-#'),
            'nacimiento' => $this->faker->date(),
            'telefono' => $this->faker->phoneNumber(),
            'domicilio' => $this->faker->address(),
            'area' => $this->faker->randomElement(['Registrado','Becario','Software','Hardware','TI']),
            'coordinador' => $this->faker->boolean(),
            'observaciones' => $this->faker->optional()->sentence(),
        ];
    }

    public function rootUser(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => env('ADMIN_USERNAME'),
            'email' => env('ADMIN_EMAIL'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
        ]);
    }
}
