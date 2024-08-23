<?php

namespace Database\Factories;

use App\Models\FileExtension;
use App\Models\Platform;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name'			=> fake()->title(),
			'short_name'	=> Str::random(8),
        ];
    }


	/**
	 * Cria as extensões de arquivo associadas à plataforma.
	 *
	 * @param integer $count
	 * @return static
	 */
	public function withFileExtensions(int $count = 5) : static
	{
		return $this->hasAttached(FileExtension::factory()->count($count));
	}
}
