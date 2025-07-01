<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_id' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->city,
            'slug' => $this->faker->name,
            'description' => $this->faker->paragraphs(5, true),
            'postal_code' => $this->faker->randomNumber(5, true),
        ];
    }
}
