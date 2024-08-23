<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
            'name'		=> $this->faker->word(),
			'priority'	=> $this->faker->randomNumber(3),
			'is_admin'	=> false,
        ];
    }


	/**
	 * Cargo gerado deve ser administrativo.
	 *
	 * @return static
	 */
	public function admin() : static
	{
		return $this->state(fn ($attributes) : array => [
			'is_admin' => true,
		]);
	}
}
