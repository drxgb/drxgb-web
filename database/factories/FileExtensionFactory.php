<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FileExtension>
 */
class FileExtensionFactory extends Factory
{
    /**
     * Definir o estado padrão do modelo.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
			'name'			=> $this->faker->text(8),
            'extension'		=> substr($this->faker->fileExtension(), 0, 3),
        ];
    }
}
