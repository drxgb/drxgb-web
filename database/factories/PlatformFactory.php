<?php

namespace Database\Factories;

use App\Models\FileExtension;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Platform>
 */
class PlatformFactory extends Factory
{
    /**
     * Definir o estado padrão do modelo.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
		$len = fake()->numberBetween(3, 12);

        return [
            'name'			=> fake()->colorName(),
			'short_name'	=> fake()->unique()->shuffleString(Str::random($len)),
        ];
    }


	/**
	 * Cria as extensões de arquivo associadas à plataforma.
	 *
	 * @param integer|null $count
	 * @return static
	 */
	public function withFileExtensions(?int $count = null) : static
	{
		$count ??= fake()->numberBetween(1, 3);
		return $this->hasAttached(FileExtension::factory()->count($count));
	}
}
