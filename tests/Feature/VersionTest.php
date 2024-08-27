<?php

namespace Tests\Feature;

use App\Models\ProductFile;
use App\Models\Version;
use App\Services\Version\CreatorService;
use Tests\TestCase;
use Tests\FakeFileSystem;
use Illuminate\Support\Str;
use Tests\CreatesAdminUser;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VersionTest extends TestCase
{
    use RefreshDatabase;
	use CreatesAdminUser;
	use FakeFileSystem;


	/**
	 * Testa se a versão pode ser criada.
	 *
	 * @return void
	 */
	public function test_version_can_be_created() : void
	{
		$this->setupFileSystem();

		$attributes = Version::factory()->raw();
		$files = $this->generateFiles();

		$version = $this->creatorService()
			->fill($attributes)
			->assign($files)
			->save();

		$this->assertModelExists($version);

		foreach ($version->productFiles as $productFile)
		{
			/** @var ProductFile $productFile */
			$path = $productFile->getFullFileName();
			$this->fs->assertExists($path);
		}
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


	/**
	 * Cria uma penca de arquivos.
	 *
	 * @return array
	 */
	private function generateFiles() : array
	{
		$length = fake()->numberBetween(1, 9);

		for ($i = 0; $i < $length; ++$i)
		{
			$name = Str::random();
			$extension = fake()->fileExtension();

			$files[$i]['name'] = $name;
			$files[$i]['product_file'] = UploadedFile::fake()->create("{$name}.{$extension}");
		}

		return $files ?? [];
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
}
