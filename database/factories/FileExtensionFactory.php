<?php

namespace Database\Factories;

use Illuminate\Support\Str;
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
			'name'			=> Str::random(),
            'extension'		=> fake()->unique()->fileExtension(),
        ];
    }
}
