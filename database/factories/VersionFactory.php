<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Version>
 */
class VersionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number'		=> $this->randomVersionNumber(),
			'release_date'	=> fake()->date(),
			'release_notes'	=> fake()->text(),
			'fixes'			=> fake()->text(),
        ];
    }


	/**
	 * Gera um número de versão aleatória.
	 * @return int
	 */
	public function randomVersionNumber() : int
	{
		$major = fake()->numberBetween(1, 2);
		$minor = fake()->numberBetween(0, 20);
		$patch = fake()->numberBetween(0, 50);
		$type = fake()->numberBetween(0, 3) * 2 + 1;
		$typeVersion = fake()->numberBetween(0, 9);

		return 	$major * 1000000 +
				$minor * 10000 +
				$patch * 100 +
				$type * 10 +
				$typeVersion;
	}
}
