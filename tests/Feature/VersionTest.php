<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Version;
use App\Models\Platform;
use Tests\FakeFileSystem;
use App\Models\ProductFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tests\CreatesAdminUser;
use App\Models\FileExtension;
use Illuminate\Http\UploadedFile;
use App\Services\Version\EditorService;
use App\Services\Version\CreatorService;
use App\Services\Version\DeleterService;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEmpty;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VersionTest extends TestCase
{
    use RefreshDatabase;
	use CreatesAdminUser;
	use FakeFileSystem;


	/**
	 * Conjunto de plataformas.
	 *
	 * @var array
	 */
	private $platforms = [];


	/**
	 * Conjunto de extensões de arquivo.
	 *
	 * @var array
	 */
	private $fileExtensions = [];


	/**
	 * Dados dos arquivos enviados.
	 *
	 * @var array
	 */
	private $files = [];


	/**
	 * Testa se a versão pode ser criada.
	 *
	 * @return void
	 */
	public function test_version_can_be_created() : void
	{
		$version = $this->createVersion();

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
		$version = $this->createVersion();
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
		$version = $this->createVersion();
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
		$version = $this->createVersion();
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
		$version = $this->createVersion();
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
	private function createVersion() : Version
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
	 * Cria as extensões de arquivo.
	 *
	 * @return void
	 */
	private function setupFileExtensions() : void
	{
		$this->clearFileExtensions();

		$this->fileExtensions = FileExtension::factory()
			->count(8)
			->create()
			->toArray();
	}


	/**
	 * Cria as plataformas.
	 *
	 * @return void
	 */
	private function setupPlatforms() : void
	{
		$this->clearPlatforms();

		$this->platforms = Platform::factory()
			->count(5)
			->afterCreating(
				function (Platform $platform) : void
				{
					$fileExtensions = $this->fileExtensions;
					$count = fake()->numberBetween(1, count($fileExtensions));
					$supportedFileExtensions = Arr::random($fileExtensions, $count);
					$ids = array_map(fn (array $ext) : int => $ext['id'], $supportedFileExtensions);

					$platform->fileExtensions()->attach($ids);
				}
			)->create()
			->toArray();
	}


	/**
	 * Configura os dados dos arquivos enviados.
	 *
	 * @param array $files
	 * @return void
	 */
	private function setupFiles(array $files) : void
	{
		foreach ($files as $file)
		{
			unset($file['product_file']);
		}

		$this->files = $files;
	}


	/**
	 * Limpa as plataformas.
	 *
	 * @return void
	 */
	private function clearPlatforms() : void
	{
		$this->platforms = [];
	}


	/**
	 * Limpa as extensões de arquivo.
	 *
	 * @return void
	 */
	private function clearFileExtensions() : void
	{
		$this->fileExtensions = [];
	}


	/**
	 * Cria uma penca de arquivos.
	 *
	 * @param ?int $length
	 * @return array
	 */
	private function generateFiles(?int $length = null) : array
	{
		$length ??= fake()->numberBetween(1, 9);

		while ($length-- > 0)
		{
			$files[] = $this->makeFile();
		}

		return $files ?? [];
	}


	/**
	 * Cria um único arquivo.
	 *
	 * @return array
	 */
	private function makeFile() : array
	{
		$count = fake()->numberBetween(1, count($this->platforms));
		$platforms = Arr::random($this->platforms, $count);
		$supportedFileExtensions = $this->supportedFileExtensions($platforms);
		$fileExtension = Arr::random($supportedFileExtensions);

		$name = Str::random(fake()->numberBetween(4, 16));
		$extension = $fileExtension['extension'];

		return [
			'name'			=> $name,
			'platform_ids'	=> $this->platformIds($platforms),
			'product_file'	=> UploadedFile::fake()->create("{$name}.{$extension}"),
		];
	}


	/**
	 * Define os IDs para os arquivos de acordo com a versão.
	 *
	 * @param Version $version
	 * @return void
	 */
	private function setFileIds(Version $version) : void
	{
		$productFiles = $version->productFiles;
		$ids = $productFiles->map(fn (ProductFile $p) : int => $p->id);
		$len = $productFiles->count();

		for ($i = 0; $i < $len; ++$i)
		{
			$this->files[$i]['id'] = $ids[$i];
		}
	}


	/**
	 * Altera os dados do arquivo a ser enviado por upload.
	 *
	 * @param array $file
	 * @return void
	 */
	private function changeFile(array &$file) : void
	{
		/** @var UploadedFile */
		$upload = $file['product_file'];
		$name = Str::random(fake()->numberBetween(4, 16));
		$extension = $upload->getClientOriginalExtension();

		$file = array_replace($file, [
			'name'			=> $name,
			'product_file'	=> UploadedFile::fake()->create("{$name}.{$extension}"),
		]);
	}


	/**
	 * Filtra as plataformas entregando somente seus IDs.
	 *
	 * @param array $platforms
	 * @return array
	 */
	private function platformIds(array $platforms) : array
	{
		return array_map(
			fn (array $platform) : int => $platform['id'],
			$platforms
		);
	}


	/**
	 * Recebe as extensões de arquivo suportadas pela plataforma.
	 *
	 * @param array $platforms
	 * @return array
	 */
	private function supportedFileExtensions(array $platforms) : array
	{
		foreach ($platforms as $platform)
		{
			$fileExtensions = array_replace(
				$fileExtensions ?? [],
				$platform['supported_file_extensions']
			);
		}

		return $fileExtensions ?? [];
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
