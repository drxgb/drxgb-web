<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Version;
use App\Services\Product\CreatorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Tests\CreatesAdminUser;
use Tests\FakeFileSystem;
use Tests\ProductFormTrait;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertNotNull;

class ProductTest extends TestCase
{
	use RefreshDatabase;
	use CreatesAdminUser;
	use FakeFileSystem;
	use ProductFormTrait;


	/**
	 * Testa se o produto pode ser criado.
	 *
	 * @return void
	 */
    public function test_product_can_be_created() : void
	{
		$attributes = Product::factory()->raw();
		$category = Category::factory()->create();
		$versions = $this->makeVersions();

		$uri = route('admin.products.store');
		$data = array_merge($attributes, [
			'category_id'	=> $category->id,
			'versions'		=> $versions,
		]);

		$response = $this->actingAs($this->user)->post($uri, $data);
		$response->assertValid();
		$response->assertRedirect();
	}


	/**
	 * Testa se o produto pode ser criado com imagens.
	 *
	 * @return void
	 */
	public function test_product_can_be_created_with_images() : void
	{
		$this->setupFileSystem();

		$attributes = Product::factory()->raw();
		$category = Category::factory()->create();
		$versions = $this->makeVersions();
		$images = $this->makeImages();
		$cover = fake()->numberBetween(1, count($images)) - 1;

		$uri = route('admin.products.store');
		$data = array_merge($attributes, [
			'cover_index'	=> $cover,
			'category_id'	=> $category->id,
			'versions'		=> $versions,
			'images'		=> $images,
		]);

		$response = $this->actingAs($this->user)->post($uri, $data);
		$response->assertValid();

		$product = Product::latest()->first();
		$productImages = $product->getFullFileName();

		assertNotNull($product);
		assertNotEmpty($productImages);

		foreach ($productImages as $image)
		{
			$this->fs->assertExists($image);
		}
	}


	/**
	 * Testa se o produto pode ser modificado.
	 *
	 * @return void
	 */
	public function test_product_can_be_updated() : void
	{
		$versions = $this->makeVersions();
		$images = $this->makeImages();
		$product = $this->createProduct($versions, $images);
		$attributes = Product::factory()->raw();

		$this->updateInputVersions($product, $versions);

		$uri = route('admin.products.update', $product);
		$data = array_merge($attributes, [
			'images'		=> $images,
			'versions'		=> $versions,
		]);

		$response = $this->actingAs($this->user)->put($uri, $data);
		$response->assertValid();
		$response->assertRedirect();
	}


	/**
	 * Testa se as imagens não utilizadas pelo produto
	 * devem ser removidas.
	 *
	 * @return void
	 */
	public function test_product_must_clean_unused_images_on_update() : void
	{
		$versions = $this->makeVersions();
		$images = $this->makeImages();
		$product = $this->createProduct($versions, $images);
		$attributes = Product::factory()->raw();
		$unusedImage = array_pop($images);

		$this->updateInputVersions($product, $versions);

		$uri = route('admin.products.update', $product);
		$data = array_merge($attributes, [
			'images'		=> $images,
			'versions'		=> $versions,
		]);

		$response = $this->actingAs($this->user)->put($uri, $data);
		$response->assertValid();
		$response->assertRedirect();

		$this->fs->assertMissing($unusedImage);
	}


	/**
	 * Testa se o produto pode ter todas as imagens removidas.
	 *
	 * @return void
	 */
	public function test_product_must_prune_images_on_update() : void
	{
		$versions = $this->makeVersions();
		$images = $this->makeImages();
		$product = $this->createProduct($versions, $images);
		$oldImages = $product->getFiles();
		$attributes = Product::factory()->raw();

		$this->updateInputVersions($product, $versions);

		$uri = route('admin.products.update', $product);
		$data = array_merge($attributes, [
			'versions'		=> $versions,
		]);

		$response = $this->actingAs($this->user)->put($uri, $data);
		$response->assertValid();
		$response->assertRedirect();

		foreach ($oldImages as $image)
		{
			$this->fs->assertMissing($image);
		}
	}


	/**
	 * Testa se as versões não utilizadas devem ser excluídas
	 * ao modificar o produto.
	 *
	 * @return void
	 */
	public function test_product_must_delete_unused_versions_on_update() : void
	{
		$versions = $this->makeVersions();
		$images = $this->makeImages();
		$product = $this->createProduct($versions, $images);
		$attributes = Product::factory()->raw();

		$this->updateInputVersions($product, $versions);

		$unusedVersionData = array_pop($versions);
		$unusedVersion = Version::find($unusedVersionData['id']);

		$uri = route('admin.products.update', $product);
		$data = array_merge($attributes, [
			'images'		=> $images,
			'versions'		=> $versions,
		]);

		$response = $this->actingAs($this->user)->put($uri, $data);
		$response->assertValid();
		$response->assertRedirect();

		$this->assertModelMissing($unusedVersion);
	}


	/**
	 * Testa se o produto não pode ser modificado sem versões.
	 *
	 * @return void
	 */
	public function test_product_cannot_have_empty_versions_on_update() : void
	{
		$versions = $this->makeVersions();
		$images = $this->makeImages();
		$product = $this->createProduct($versions, $images);
		$attributes = Product::factory()->raw();

		$this->updateInputVersions($product, $versions);

		$uri = route('admin.products.update', $product);
		$data = array_merge($attributes, [
			'images'		=> $images,
			'versions'		=> [],
		]);

		$response = $this->actingAs($this->user)->put($uri, $data);
		$response->assertInvalid();
	}


	/**
	 * Testa se o produto pode ser removido.
	 */
	public function test_product_can_be_deleted() : void
	{
		$versions = $this->makeVersions();
		$images = $this->makeImages();
		$product = $this->createProduct($versions, $images);
		$oldImages = $product->getFiles();
		$oldVersions = $product->versions;

		$uri = route('admin.products.destroy', $product);
		$response = $this->actingAs($this->user)->delete($uri);

		$response->assertValid();
		$response->assertRedirect();
		$this->assertModelMissing($product);

		foreach ($oldImages as $image)
		{
			$this->fs->assertMissing($image);
		}
		foreach ($oldVersions as $version)
		{
			$this->assertModelMissing($version);
		}
	}


	/**
	 * @return void
	 */
	protected function setUp() : void
	{
		parent::setUp();
		$this->createAdminUser();
		$this->setupFileExtensions();
		$this->setupPlatforms();
	}


	/**
	 * @return void
	 */
	protected function tearDown() : void
	{
		$this->deleteAdminUser();
		$this->clearPlatforms();
		$this->clearFileExtensions();
		parent::tearDown();
	}


	/**
	 * Cria o campo da versão.
	 *
	 * @return array
	 */
	private function makeVersion() : array
	{
		$version = Version::factory()->raw();
		$version['files'] = $this->generateFiles();

		return $version;
	}


	/**
	 * Cria os campos da versão.
	 *
	 * @param integer|null $count
	 * @return array
	 */
	private function makeVersions(?int $count = null) : array
	{
		$count ??= fake()->numberBetween(1, 7);

		for ($i = 0; $i < $count; ++$i)
		{
			$versions[] = $this->makeVersion();
		}

		return $versions;
	}


	/**
	 * Cria imagens aleatórias para o produto.
	 *
	 * @return array
	 */
	private function makeImages() : array
	{
		$count = fake()->numberBetween(1, 20);

		for ($i = 0; $i < $count; ++$i)
		{
			$name = Str::random();
			$images[] = UploadedFile::fake()->image($name);
		}

		return $images ?? [];
	}


	/**
	 * Cria um produto com imagens e versões.
	 *
	 * @param array $versions
	 * @param array $images
	 * @return Product
	 */
	private function createProduct(array $versions = [], array $images = []) : Product
	{
		$this->setupFileSystem();

		$cover = ! empty($images)
			? fake()->numberBetween(1, count($images)) - 1
			: null;

		$category = Category::factory()->create();
		$attributes = Product::factory()->raw([ 'cover_index' => $cover ]);

		return $this->creatorService()
			->fill($attributes)
			->assign($versions)
			->associate($category)
			->setUploadedFiles($images)
			->shouldRefresh()
			->save();
	}


	/**
	 * Atualiza os campos das versões inserindo os IDs.
	 *
	 * @param Product $product
	 * @param array $versions
	 * @return void
	 */
	private function updateInputVersions(Product $product, array &$versions) : void
	{
		$productVersions = $product->versions->toArray();
		$version = reset($productVersions);
		$len = count($versions);

		for ($i = 0; $i < $len; ++$i)
		{
			$versions[$i]['id'] = $version['id'];
			$version = next($productVersions);
		}
	}


	/**
	 * Cria um serviço de criação do produto.
	 *
	 * @return CreatorService
	 */
	private function creatorService() : CreatorService
	{
		return app(CreatorService::class);
	}
}
