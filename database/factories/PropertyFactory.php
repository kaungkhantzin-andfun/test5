<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => random_int(1, 10),
            'slug' => $this->faker->slug,
            'price' => random_int(100, 10000000),
            'property_purpose_id' => $this->faker->numberBetween(1, 4),
            'parking' => random_int(0, 3),
            'area' => $this->faker->numerify('##x##'),
            'beds' => $this->faker->numberBetween(0, 5),
            'baths' => $this->faker->numberBetween(0, 5),
            'featured' => $this->faker->dateTimeBetween('-2 week', '-1 day'),
            'map' => $this->faker->sentence,
            'stat' => $this->faker->numberBetween(0, 10000),
            'keyword' => $this->faker->name,
        ];
    }
}
