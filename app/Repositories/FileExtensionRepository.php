<?php

namespace App\Repositories;

use App\Models\FileExtension;
use Illuminate\Http\Request;


/**
 * Responsável por criar, atualizar e apagar extensões de arquivo.
 *
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
class FileExtensionRepository
{
	use HasIcon;


	/**
	 * Cria uma nova extensão de arquivo.
	 *
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
		if ($fileExtension->isDirty())
			$fileExtension->save();

		return $fileExtension;
	}


	/**
	 * Atualiza a extensão de arquivo.
	 *
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
		$this->deleteIconIfNeeded($request, $fileExtension);
		$this->uploadIconIfNeeded($request, $fileExtension);
		$fileExtension->save();
	}


	/**
	 * Apaga a extensão de arquivo.
	 *
	 * @param FileExtension $fileExtension
	 * @return void
	 */
	public function delete(FileExtension $fileExtension) : void
	{
		$fileExtension->delete();
		$fileExtension->deleteIcon();
	}
}
