<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesAdminUser;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

class CategoryTest extends TestCase
{
	use RefreshDatabase;
	use CreatesAdminUser;


	/**
	 * Testa se a categoria pode ser criada.
	 *
	 * @return void
	 */
	public function test_can_be_created() : void
	{
		$uri = route('admin.categories.store');
		$data = Category::factory()->raw();
		$response = $this->actingAs($this->user)->post($uri, $data);

		$response->assertRedirect();
	}


	/**
	 * Testa se a categoria pode ser criada com uma
	 * categoria pai.
	 *
	 * @return void
	 */
	public function test_can_be_created_with_parent() : void
	{
		$parent = Category::factory()->create();

		$uri = route('admin.categories.store');
		$data = array_merge(Category::factory()->raw(), [
			'parent_id'	=> $parent->id,
		]);

		$response = $this->actingAs($this->user)->post($uri, $data);
		$category = Category::where('parent_id', $parent->id)->first();

		$response->assertRedirect();
		assertTrue($category->parent_id === $parent->id);
	}


	/**
	 * Testa se pode ser atualizado.
	 *
	 * @return void
	 */
	public function test_can_be_updated() : void
	{
		$category = Category::factory()->create();
		$uri = route('admin.categories.update', $category);
		$data = Category::factory()->raw();

		$response = $this->actingAs($this->user)->put($uri, $data);
		$response->assertRedirect();
	}


	/**
	 * Testa se a categoria pai pode ser removida.
	 *
	 * @return void
	 */
	public function test_can_remove_parent() : void
	{
		$category = Category::factory()->withParent()->create();
		$uri = route('admin.categories.update', $category);
		$data = array_merge(Category::factory()->raw(), [
			'parent_id'	=> null,
		]);

		$response = $this->actingAs($this->user)->put($uri, $data);
		$category = Category::where('id', $category->id)->first();

		$response->assertRedirect();
		assertEquals(null, $category->parent_id);
	}


	/**
	 * Testa se a categoria pode ser deletada.
	 *
	 * @return void
	 */
	public function test_can_be_deleted() : void
	{
		$category = Category::factory()->create();
		$uri = route('admin.categories.destroy', $category);

		$response = $this->actingAs($this->user)->delete($uri);
		$response->assertRedirect();
		$this->assertModelMissing($category);
	}


	/**
	 * Testa se a categoria pode ser removida, fazendo,
	 * também, para as suas subcategorias.
	 *
	 * @return void
	 */
	public function test_can_be_deleted_on_cascade() : void
	{
		$category = Category::factory()->withParent()->create();
		$parent = $category->parent;
		$uri = route('admin.categories.destroy', $parent);

		$response = $this->actingAs($this->user)->delete($uri);
		$response->assertRedirect();
		$this->assertModelMissing($parent);
		$this->assertModelMissing($category);
	}


	/**
	 * @return void
	 */
	protected function setUp() : void
	{
		parent::setUp();
		$this->createAdminUser();
	}


	/**
	 * @return void
	 */
	protected function tearDown() : void
	{
		$this->deleteAdminUser();
		parent::tearDown();
	}
}
