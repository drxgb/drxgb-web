<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
            'name'	=> fake()->title(),
        ];
    }


	/**
	 * Cria uma categoria pai.
	 *
	 * @return static
	 */
	public function withParent() : static
	{
		return $this->for($this->create(), 'parent');
	}
}
