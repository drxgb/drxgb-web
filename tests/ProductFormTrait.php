<?php

namespace Tests;

use App\Models\Version;
use App\Models\Platform;
use App\Models\ProductFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\FileExtension;
use Illuminate\Http\UploadedFile;


trait ProductFormTrait
{
	/**
	 * Conjunto de plataformas.
	 *
	 * @var array
	 */
	protected $platforms = [];


	/**
	 * Conjunto de extensões de arquivo.
	 *
	 * @var array
	 */
	protected $fileExtensions = [];


	/**
	 * Dados dos arquivos enviados.
	 *
	 * @var array
	 */
	protected $files = [];


	/**
	 * Cria as extensões de arquivo.
	 *
	 * @return void
	 */
	protected function setupFileExtensions() : void
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
	protected function setupPlatforms() : void
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
	protected function setupFiles(array $files) : void
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
	protected function clearPlatforms() : void
	{
		$this->platforms = [];
	}


	/**
	 * Limpa as extensões de arquivo.
	 *
	 * @return void
	 */
	protected function clearFileExtensions() : void
	{
		$this->fileExtensions = [];
	}


	/**
	 * Cria uma penca de arquivos.
	 *
	 * @param ?int $length
	 * @return array
	 */
	protected function generateFiles(?int $length = null) : array
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
	protected function makeFile() : array
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
	protected function setFileIds(Version $version) : void
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
	protected function changeFile(array &$file) : void
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
	protected function platformIds(array $platforms) : array
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
	protected function supportedFileExtensions(array $platforms) : array
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
}
