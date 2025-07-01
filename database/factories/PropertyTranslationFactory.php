<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyTranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PropertyTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'property_id' => $this->faker->unique()->numberBetween(1, 30),
            'locale' => $this->faker->randomElement(['my', 'en']),
            'title' => $this->faker->sentence,
            'detail' => $this->faker->text,
            'address' => $this->faker->sentence,
        ];
    }
}
