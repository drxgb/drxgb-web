<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductFile;
use App\Models\Version;
use App\Services\Version\CreatorService;
use App\Services\Version\DeleterService;
use App\Services\Version\EditorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesAdminUser;
use Tests\FakeFileSystem;
use Tests\ProductFormTrait;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEmpty;

class VersionTest extends TestCase
{
    use RefreshDatabase;
	use CreatesAdminUser;
	use FakeFileSystem;
	use ProductFormTrait;


	/**
	 * Testa se a versão pode ser criada.
	 *
	 * @return void
	 */
	public function test_version_can_be_created() : void
	{
		$version = $this->makeVersion();

		$this->assertModelExists($version);

		foreach ($version->productFiles as $productFile)
		{
			/** @var ProductFile $productFile */
			$path = $productFile->getFullFileName();

			$this->assertModelExists($productFile);
			$this->fs->assertExists($path);
		}
	}


	/**
	 * Testa se a versão pode ser modificada.
	 *
	 * @return void
	 */
	public function test_version_can_be_updated() : void
	{
		$version = $this->makeVersion();
		$attributes = Version::factory()->raw();
		$files = $this->files;

		app(EditorService::class, compact('version'))
			->fill($attributes)
			->assign($files)
			->save();

		assertEquals($version->number, $attributes['number']);
	}


	/**
	 * Testa se pode atualizar os arquivos.
	 *
	 * @return void
	 */
	public function test_version_can_update_files() : void
	{
		$version = $this->makeVersion();
		$this->setFileIds($version);

		$productFiles = $version->productFiles;
		$oldProductFile = $productFiles->first();
		$unusedProductFile = $productFiles->last();

		$oldFilePath = $oldProductFile->getFullFileName();

		$this->changeFile($this->files[0]);
		array_pop($this->files);

		$this->editorService($version)
			->assign($this->files)
			->save();

		$this->fs->assertMissing($oldFilePath);
		$this->fs->assertMissing($unusedProductFile->getFullFileName());
	}


	/**
	 * Testa se os arquivos não utilizados foram removidos.
	 *
	 * @return void
	 */
	public function test_version_can_prune_unused_files() : void
	{
		$version = $this->makeVersion();
		$this->setFileIds($version);

		$previousProductFiles = $version->productFiles;

		$files = $this->generateFiles();
		$this->setupFiles($files);

		$this->editorService($version)
			->assign($files)
			->save();

		assertNotEmpty($previousProductFiles);

		foreach ($previousProductFiles as $productFile)
		{
			/** @var ProductFile $productFile */
			$this->assertModelMissing($productFile);
			$this->fs->assertMissing($productFile->getFullFileName());
		}
	}


	/**
	 * Testa se a versão pode ser removida.
	 *
	 * @return void
	 */
	public function test_version_can_be_deleted() : void
	{
		$version = $this->makeVersion();
		$productFiles = $version->productFiles;

		$this->deleterService($version)->delete();

		assertNotEmpty($productFiles);

		foreach ($productFiles as $productFile)
		{
			/** @var ProductFile $productFile */
			$this->fs->assertMissing($productFile->getFullFileName());
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
	 * Cria uma versão.
	 *
	 * @return Version
	 */
	private function makeVersion() : Version
	{
		$this->setupFileSystem();

		$attributes = Version::factory()->raw();
		$product = Product::factory()->create();
		$files = $this->generateFiles();

		$this->setupFiles($files);

		return $this->creatorService()
			->fill($attributes)
			->associate($product->id)
			->assign($files)
			->save();
	}


	/**
	 * Gera um novo seriço de criação de versão.
	 *
	 * @return CreatorService
	 */
	private function creatorService() : CreatorService
	{
		return app(CreatorService::class);
	}


	/**
	 * Gera um novo serviço de edição da versão.
	 *
	 * @param Version $version
	 * @return EditorService
	 */
	private function editorService(Version $version) : EditorService
	{
		return app(EditorService::class, compact('version'));
	}


	/**
	 * Gera um novo serviço de remoção da versão.
	 *
	 * @param Version $version
	 * @return DeleterService
	 */
	private function deleterService(Version $version) : DeleterService
	{
		return app(DeleterService::class, compact('version'));
	}
}
