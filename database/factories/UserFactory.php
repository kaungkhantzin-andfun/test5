<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role' => $this->faker->randomElement(['user', 'agent']),
            'service_region_id' => $this->faker->numberBetween(1, 14),
            'service_township_id' => serialize($this->faker->numberBetween(1, 100)),
            'address' => $this->faker->address,
            'about' => $this->faker->paragraphs(5, true),
            'partner' => $this->faker->dateTimeBetween('-2 weeks', '-1 day'),
            'featured' => $this->faker->dateTimeBetween('-2 weeks', '-1 day'),
        ];
    }
}
