<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductFile>
 */
class ProductFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
            'name'		=> fake()->title(),
			'size'		=> fake()->randomNumber(4),
			'file_path'	=> fake()->filePath(),
        ];
    }
}
