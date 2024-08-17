<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Language>
 */
class LanguageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
            'name'		=> $this->faker->countryISOAlpha3(),
			'locale'	=> $this->faker->locale(),
			'country_flag'	=> $this->faker->countryCode(),
        ];
    }
}
