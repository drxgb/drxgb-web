<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Version;
use App\Models\Category;
use Database\Seeders\PlatformSeeder;
use Illuminate\Support\Facades\Storage;
use Database\Seeders\FileExtensionSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class CreateProductTest extends TestCase
{
	use RefreshDatabase, WithFaker;


    /**
     * Testa se o produto pode ser criado.
     */
    public function test_products_can_be_created(): void
    {
		$user = User::factory()
			->for(Role::factory()->create())
			->create();
		$category = Category::factory()->create();

		$this->seed([
			PlatformSeeder::class,
			FileExtensionSeeder::class,
		]);

		Storage::fake('product-files');

		$file = UploadedFile::fake()->create('test.js');
		$file->storeAs('/', 'test.js', 'product-files');

		$data = [
			'title'			=> $this->faker->word(),
			'slug'			=> $this->faker->slug(3),
			'page'			=> null,
			'description'	=> $this->faker->paragraph(),
			'price'			=> $this->faker->randomNumber(2),
			'active'		=> $this->faker()->boolean(90),
			'category_id'	=> $category->id,
			'versions'		=> [
				[
					'id'			=> null,
					'number'		=> Version::factory()->randomVersionNumber(),
					'release_date'	=> $this->faker->date(),
					'release_notes'	=> $this->faker->text(),
					'fixes'			=> $this->faker->text(),
					'files'			=> [
						[
							'id'			=> null,
							'name'			=> null, //$this->faker->word(),
							'path'			=> null,
							'platform_ids'	=> [ 1, 2 ],
							'product_file'	=> $file,
						],
					],
				],
			],
		];

        $response = $this->actingAs($user)->post(route('admin.products.store'), $data);
        $response->assertSessionHasNoErrors();
		$response->assertRedirectToRoute('admin.products.index');
    }
}
