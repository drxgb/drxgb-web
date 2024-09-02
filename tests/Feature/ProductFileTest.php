<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Version;
use App\Models\Platform;
use Tests\FakeFileSystem;
use App\Models\ProductFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\FileExtension;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\QueryException;
use App\Exceptions\DisassociationException;
use App\Services\ProductFile\EditorService;
use App\Services\ProductFile\CreatorService;
use App\Services\ProductFile\DeleterService;

use function PHPUnit\Framework\assertEquals;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ProductFileTest extends TestCase
{
	use RefreshDatabase;
	use FakeFileSystem;


	/**
	 * Extensões de arquivo disponíveis.
	 *
	 * @var array
	 */
	private $availableFileExtensions = [];


	/**
	 * Testa se o produto pode ser criado.
	 *
	 * @return void
	 */
    public function test_product_file_can_be_created() : void
	{
		$this->setupFileSystem();

		$attributes = ProductFile::factory()->raw();
		$version = Version::factory()->withProduct()->create();
		$platforms = $this->makePlatforms();

		$this->updateAvailableFileExtensions($platforms);

		$file = $this->generateFile();

		/** @var ProductFile */
		$productFile = $this->creatorService()
			->fill($attributes)
			->associate($version)
			->attach($platforms)
			->setUploadedFile($file)
			->save();

		$this->fs->assertExists($productFile->getFullFileName());
		$this->assertModelExists($productFile);
	}


	/**
	 * Testa se o produto não pode ser criado sem pertencer a nenhuma versão.
	 *
	 * @return void
	 */
	public function test_product_file_cannot_be_created_without_version() : void
	{
		$this->assertThrows(
			function () : void
			{
				$this->setupFileSystem();

				$attributes = ProductFile::factory()->raw();
				$file = $this->generateFile();

				$creator = $this->creatorService();
				$creator->fill($attributes)
					->setUploadedFile($file)
					->save();
			},
			QueryException::class
		);
	}


	/**
	 * Testa se o arquivo não pode ser criado com uma extensão inválida.
	 *
	 * @return void
	 */
	public function test_product_file_cannot_be_created_with_an_invalid_extension() : void
	{
		$this->assertThrows(
			function () : void
			{
				$this->setupFileSystem();

			$attributes = ProductFile::factory()->raw();
			$version = Version::factory()->withProduct()->create();
			$platforms = $this->makePlatforms();

			$this->updateAvailableFileExtensions($platforms);

			$file = $this->generateFile(extension: 'kekeke');

			$this->creatorService()
				->fill($attributes)
				->associate($version)
				->attach($platforms)
				->setUploadedFile($file)
				->save();
			},
			\LogicException::class
		);
	}


	/**
	 * Testa se o produto pode ser modificado.
	 *
	 * @return void
	 */
	public function test_product_file_can_be_updated() : void
	{
		$this->setupFileSystem();

		$attributes = ProductFile::factory()->raw();
		$version = Version::factory()->withProduct()->create();
		$file = $this->generateFile();

		$creator = $this->creatorService();

		/** @var ProductFile */
		$productFile = $creator->fill($attributes)
			->associate($version)
			->setUploadedFile($file)
			->save();

		$name = fake()->name();
		$editor = $this->editorService($productFile);
		$productFile = $editor->fill(compact('name'))->save();

		assertEquals($name, $productFile->name);
	}


	/**
	 * Testa se o produto pode alterar o arquivo.
	 *
	 * @return void
	 */
	public function test_product_file_can_change_file() : void
	{
		$this->setupFileSystem();
		$fs = $this->fs;

		$attributes = ProductFile::factory()->raw();
		$version = Version::factory()->withProduct()->create();
		$platforms = $this->makePlatforms();

		$this->updateAvailableFileExtensions($platforms);

		$oldFile = $this->generateFile();

		/** @var ProductFile */
		$productFile = $this->creatorService()
			->fill($attributes)
			->associate($version)
			->attach($platforms)
			->setUploadedFile($oldFile)
			->save();
		$oldPath = $productFile->getFullFileName();
		$platforms = $this->makePlatforms();

		$this->clearAvailableFileExtensions();
		$this->updateAvailableFileExtensions($platforms);

		$newFile = $this->generateFile();

		$productFile = $this->editorService($productFile)
			->sync($platforms)
			->setUploadedFile($newFile)
			->save();
		$newPath = $productFile->getFullFileName();

		$fs->assertMissing($oldPath);
		$fs->assertExists($newPath);
	}


	/**
	 * Testa se o arquivo do produto não pode ser atualizado
	 * com uma extensão de arquivo inválida.
	 *
	 * @return void
	 */
	public function test_product_file_cannot_update_with_an_invalid_extension() : void
	{
		$this->assertThrows(
			function () : void
			{
				$this->setupFileSystem();

				$attributes = ProductFile::factory()->raw();
				$version = Version::factory()->withProduct()->create();
				$platforms = $this->makePlatforms();

				$this->updateAvailableFileExtensions($platforms);

				$oldFile = $this->generateFile();
				$newFile = $this->generateFile(extension: 'kekekek');

				/** @var ProductFile */
				$productFile = $this->creatorService()
					->fill($attributes)
					->associate($version)
					->attach($platforms)
					->setUploadedFile($oldFile)
					->save();
				$platforms = $this->makePlatforms();

				$this->clearAvailableFileExtensions();
				$this->updateAvailableFileExtensions($platforms);

				$this->editorService($productFile)
					->sync($platforms)
					->setUploadedFile($newFile)
					->save();
			},
			\LogicException::class
		);
	}


	/**
	 * Testa se o arquivo do produto pode ter suas plataformas
	 * alteradas.
	 *
	 * @return void
	 */
	public function test_product_file_can_change_platforms() : void
	{
		$this->setupFileSystem();

		$attributes = ProductFile::factory()->raw();
		$version = Version::factory()->withProduct()->create();
		$platforms = $this->makePlatforms();

		$this->updateAvailableFileExtensions($platforms);

		$file = $this->generateFile();

		$unexpectedIds = array_map(fn (array $platform) : int => $platform['id'], $platforms);

		/** @var ProductFile */
		$productFile = $this->creatorService()
			->fill($attributes)
			->associate($version)
			->attach($platforms)
			->setUploadedFile($file)
			->save();

		$platforms = $this->makePlatforms();
		$productFile = $this->editorService($productFile)
			->sync($platforms)
			->save();

		$expectedIds = array_map(fn (array $platform) : int => $platform['id'], $platforms);
		$actualIds = $productFile->platform_ids;

		$this->assertNotEmpty($actualIds);

		foreach ($actualIds as $id)
		{
			$this->assertContains($id, $expectedIds);
			$this->assertNotContains($id, $unexpectedIds);
		}
	}


	/**
	 * Testa se o produto não deve se desassociar de uma versão.
	 *
	 * @return void
	 */
	public function test_product_file_cannot_disassociate_from_a_version() : void
	{
		$this->assertThrows(
			function () : void
			{
				$this->setupFileSystem();

				$attributes = ProductFile::factory()->raw();
				$version = Version::factory()->withProduct()->create();
				$file = $this->generateFile();

				$creator = $this->creatorService();

				/** @var ProductFile */
				$productFile = $creator->fill($attributes)
					->associate($version)
					->setUploadedFile($file)
					->save();

				$editor = $this->editorService($productFile);
				$productFile = $editor->disassociate()->save();
			},
			DisassociationException::class
		);
	}


	/**
	 * Testa se o arquivo do produto pode ser removido.
	 *
	 * @return void
	 */
	public function test_product_file_can_be_deleted() : void
	{
		$this->setupFileSystem();

		$attributes = ProductFile::factory()->raw();
		$version = Version::factory()->withProduct()->create();
		$file = $this->generateFile();

		$creator = $this->creatorService();

		/** @var ProductFile */
		$productFile = $creator->fill($attributes)
			->associate($version)
			->setUploadedFile($file)
			->save();

		$deleter = $this->deleterService($productFile);
		$deleter->delete();

		$this->assertModelMissing($productFile);
		$this->fs->assertMissing($productFile->getFullFileName());
	}


	/**
	 * @return void
	 */
	#[\Override]
	protected function setUp() : void
	{
		parent::setUp();
		$this->clearAvailableFileExtensions();
	}


	/**
	 * @return void
	 */
	#[\Override]
	protected function tearDown() : void
	{
		$this->clearAvailableFileExtensions();
		parent::tearDown();
	}


	/**
	 * Gera um arquivo.
	 *
	 * @param ?string $name
	 * @param ?string $extension
	 * @return UploadedFile
	 */
	private function generateFile(?string $name = null, ?string $extension = null) : UploadedFile
	{
		$extension ??= empty($this->availableFileExtensions)
			? fake()->fileExtension()
			: Arr::random($this->availableFileExtensions);

		$name ??= Str::random();
		$size = fake()->numberBetween(0, 255);
		$file = UploadedFile::fake()->create("{$name}.{$extension}", $size);

		return $file;
	}


	/**
	 * Cria um conjunto de plataformas.
	 *
	 * @param integer|null $count
	 * @return array
	 */
	private function makePlatforms(?int $count = null) : array
	{
		$count ??= fake()->numberBetween(1, 5);

		return Platform::factory()
			->withFileExtensions()
			->count($count)
			->create()
			->toArray();
	}


	/**
	 * Atualiza a lista de extensões de arquivo suportadas.
	 *
	 * @param array $platforms
	 * @return void
	 */
	private function updateAvailableFileExtensions(array $platforms) : void
	{
		foreach ($platforms as $platform)
		{
			$this->availableFileExtensions = array_replace(
				$this->availableFileExtensions,
				array_map(
					fn (FileExtension $ext) : string => $ext->extension,
					$platform['supported_file_extensions']
				)
			);
		}
	}


	/**
	 * Limpa a lista de extensões de arquivo suportadas.
	 *
	 * @return void
	 */
	private function clearAvailableFileExtensions() : void
	{
		$this->availableFileExtensions = [];
	}


	/**
	 * Recebe o serviço de criação do arquivo do produto.
	 *
	 * @return CreatorService
	 */
	private function creatorService() : CreatorService
	{
		return app(CreatorService::class);
	}


	/**
	 * Recebe o serviço de edição do arquivo do produto.
	 *
	 * @param ProductFile $productFile
	 * @return EditorService
	 */
	private function editorService(ProductFile &$productFile) : EditorService
	{
		return app(EditorService::class, compact('productFile'));
	}


	/**
	 * Recebe o serviço de removção do arquivo do produto.
	 *
	 * @param ProductFile $productFile
	 * @return DeleterService
	 */
	private function deleterService(ProductFile &$productFile) : DeleterService
	{
		return app(DeleterService::class, compact('productFile'));
	}
}
