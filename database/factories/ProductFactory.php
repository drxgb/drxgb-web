<?php

namespace Database\Factories;

use App\Models\Version;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
            'title'			=> fake()->title(),
			'slug'			=> fake()->slug(),
			'description'	=> fake()->text(),
			'price'			=> fake()->randomFloat(2, max: 999.99),
			'active'		=> fake()->boolean(90),
        ];
    }


	/**
	 * Cria uma categoria vinculada ao produto.
	 *
	 * @return static
	 */
	public function withCategory() : static
	{
		return $this->for(Category::factory());
	}


	/**
	 * Cria versões e as vincula ao produto.
	 *
	 * @param ?int $count
	 * @return static
	 */
	public function withVersions(?int $count = null) : static
	{
		$count ??= fake()->randomNumber();
		return $this->hasVersions($count);
	}
}
