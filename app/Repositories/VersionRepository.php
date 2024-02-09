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
	 * Atualiza uma versão existente.
	 * @param array $data
	 * @param Version $version
	 * @return void
	 */
	public function update(array $data, Version $version) : void
	{
		$version->update([
			'number'		=> $data['number'],
			'release_date'	=> $data['release_date'],
			'release_notes'	=> $data['release_notes'],
			'fixes'			=> $data['fixes'],
		]);

		$this->saveFiles($data['files'], $version);
		$this->checkFilestoDelete($data['deleted_files'] ?? []);
		$version->save();
	}


	/**
	 * Apaga a versão.
	 * @param Version $version
	 * @return void
	 */
	public function delete(Version $version) : void
	{
		foreach ($version->productFiles()->get() as $productFile)
		{
			$this->deleteFile($productFile);
		}
		$version->delete();
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
			if (isset($fileData['product_file']))
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
				$productFile->platforms()->attach($fileData['platform_ids']);

				if ($productFile->isDirty())
					$productFile->save();
			}
		}
	}


	/**
	 * Apaga o arquivo da versão.
	 * @param ProductFile $file
	 * @return void
	 */
	private function deleteFile(ProductFile $productFile) : void
	{
		$productFile->platforms()->detach();
		$productFile->deleteFile();
		$productFile->delete();
	}


	/**
	 * Verifica se há arquivos para deletar.
	 * @param array $ids
	 * @return void
	 */
	private function checkFilestoDelete(array $ids) : void
	{
		foreach ($ids as $id)
		{
			$productFile = ProductFile::find($id);
			if ($productFile)
				$this->deleteFile($productFile);
		}
	}
}
