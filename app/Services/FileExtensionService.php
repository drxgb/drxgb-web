<?php

namespace App\Services;

use App\Models\FileExtension;
use Illuminate\Http\Request;

class FileExtensionService
{
	use HasIcon;


	/**
	 * Cria uma nova extensão de arquivo.
	 * @param Request $request
	 * @return FileExtension
	 */
	public function store(Request $request) : FileExtension
	{
		$fileExtension = FileExtension::create([
			'name'		=> $request->name,
			'extension'	=> $request->extension,
		]);

		$this->uploadIconIfNeeded($request, $fileExtension);
		return $fileExtension;
	}


	/**
	 * Atualiza a extensão de arquivo.
	 * @param Request $request
	 * @param FileExtension $fileExtension
	 * @return void
	 */
	public function update(Request $request, FileExtension $fileExtension) : void
	{
		$fileExtension->update([
			'name'		=> $request->name,
			'extension'	=> $request->extension,
		]);
		if (!$this->uploadIconIfNeeded($request, $fileExtension))
			$this->deleteIconIfNeeded($request, $fileExtension);

		if ($fileExtension->isDirty())
			$fileExtension->save();
	}


	/**
	 * Apaga a extensão de arquivo.
	 * @param \App\Models\FileExtension $fileExtension
	 * @return void
	 */
	public function delete(FileExtension $fileExtension) : void
	{

	}
}
