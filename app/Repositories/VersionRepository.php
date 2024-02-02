<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Version;
use App\Models\ProductFile;
use Illuminate\Http\UploadedFile;

class VersionRepository
{
	/**
	 * Cria uma nova versão.
	 * @param array $data
	 * @param Product $product
	 * @return Version
	 */
	public function store(array $data, Product $product) : Version
	{
		$version = Version::create([
			'number'		=> $data['number'],
			'release_date'	=> $data['release_date'],
			'release_notes'	=> $data['release_notes'],
			'fixes'			=> $data['fixes'],
		]);
		$product->versions()->save($version);
		$this->saveFiles($data['files'], $version);

		return $version;
	}


	/**
	 * Salva os arquivos de produto.
	 * @param array $data
	 * @param Version $version
	 * @return void
	 */
	private function saveFiles(array $data, Version $version) : void
	{
		foreach ($data as $fileData)
		{
			/** @var UploadedFile $file */
			$file = $fileData['product_file'];
			$productFile = ProductFile::updateOrCreate(
				[ 'id' => $fileData['id'] ],
				[
					'name' => $fileData['name'] ?? $file->getClientOriginalName(),
					'size'	=> $file->getSize(),
				]
			);
			$productFile->saveFile($file);
			$version->productFiles()->save($productFile);

			if ($productFile->isDirty())
				$productFile->save();
		}
	}
}
