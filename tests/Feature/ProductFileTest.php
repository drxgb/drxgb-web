<?php

namespace Tests\Feature;

use App\Exceptions\DisassociationException;
use App\Models\ProductFile;
use App\Models\Version;
use App\Services\ProductFile\CreatorService;
use App\Services\ProductFile\DeleterService;
use App\Services\ProductFile\EditorService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Tests\FakeFileSystem;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;


class ProductFileTest extends TestCase
{
	use RefreshDatabase;
	use FakeFileSystem;


	/**
	 * Testa se o produto pode ser criado.
	 *
	 * @return void
	 */
    public function test_product_file_can_be_created() : void
	{
		$this->setupFileSystem();

		$attributes = ProductFile::factory()->raw();
		$version = Version::factory()->create();
		$file = $this->generateFile();

		/** @var ProductFile */
		$productFile = $this->getCreatorService()->fill($attributes)
			->associate($version)
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

				$creator = $this->getCreatorService();
				$creator->fill($attributes)
					->setUploadedFile($file)
					->save();
			},
			QueryException::class
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
		$version = Version::factory()->create();
		$file = $this->generateFile();

		$creator = $this->getCreatorService();

		/** @var ProductFile */
		$productFile = $creator->fill($attributes)
			->associate($version)
			->setUploadedFile($file)
			->save();

		$name = fake()->name();
		$editor = $this->getEditorService($productFile);
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
		$version = Version::factory()->create();
		$oldFile = $this->generateFile();
		$newFile = $this->generateFile();

		$creator = $this->getCreatorService();

		/** @var ProductFile */
		$productFile = $creator->fill($attributes)
			->associate($version)
			->setUploadedFile($oldFile)
			->save();
		$oldPath = $productFile->getFullFileName();

		$editor = $this->getEditorService($productFile);
		$productFile = $editor->setUploadedFile($newFile)->save();
		$newPath = $productFile->getFullFileName();

		$fs->assertMissing($oldPath);
		$fs->assertExists($newPath);
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
				$version = Version::factory()->create();
				$file = $this->generateFile();

				$creator = $this->getCreatorService();

				/** @var ProductFile */
				$productFile = $creator->fill($attributes)
					->associate($version)
					->setUploadedFile($file)
					->save();

				$editor = $this->getEditorService($productFile);
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
		$version = Version::factory()->create();
		$file = $this->generateFile();

		$creator = $this->getCreatorService();

		/** @var ProductFile */
		$productFile = $creator->fill($attributes)
			->associate($version)
			->setUploadedFile($file)
			->save();

		$deleter = $this->getDeleterService($productFile);
		$deleter->delete();

		$this->assertModelMissing($productFile);
		$this->fs->assertMissing($productFile->getFullFileName());
	}


	/**
	 * Gera um arquivo.
	 *
	 * @param ?string $name
	 * @return UploadedFile
	 */
	private function generateFile(?string $name = null) : UploadedFile
	{
		$name ??= Str::random();
		$extension = substr(fake()->fileExtension(), 0, 8);
		$size = fake()->randomNumber(3);
		$file = UploadedFile::fake()->create("{$name}.{$extension}", $size);

		return $file;
	}


	/**
	 * Recebe o serviço de criação do arquivo do produto.
	 *
	 * @return CreatorService
	 */
	private function getCreatorService() : CreatorService
	{
		return app(CreatorService::class);
	}


	/**
	 * Recebe o serviço de edição do arquivo do produto.
	 *
	 * @param ProductFile $productFile
	 * @return EditorService
	 */
	private function getEditorService(ProductFile &$productFile) : EditorService
	{
		return app(EditorService::class, compact('productFile'));
	}


	/**
	 * Recebe o serviço de removção do arquivo do produto.
	 *
	 * @param ProductFile $productFile
	 * @return DeleterService
	 */
	private function getDeleterService(ProductFile &$productFile) : DeleterService
	{
		return app(DeleterService::class, compact('productFile'));
	}
}
