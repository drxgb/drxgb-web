<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;


trait HasIcon
{
	/**
	 * Recebe a imagem do ícone da extensão.
	 *
	 * @return Attribute
	 */
	public function icon() : Attribute
	{
		return Attribute::get(function () : string {
			return ($this->icon_path)
				? Storage::url($this->iconPath())
				: $this->defaultIcon();
		});
	}


	/**
	 * Recebe o caminho do ícone.
	 *
	 * @return string
	 */
	public function iconPath() : string
	{
		return $this->getRootFolder() . '/' . $this->icon_path;
	}


	/**
	 * Salva o arquivo do ícone.
	 *
	 * @param UploadedFile $upload
	 * @return void
	 */
	public function saveFile(UploadedFile $upload) : void
	{
		$imgExtension = $upload->extension();
		$filename = $this->getFileName() . '.' . $imgExtension;
		$upload->storePubliclyAs($this->getRootFolder(), $filename, 'public');
		$this->icon_path = $filename;
	}


	/**
	 * O caminho do arquivo do ícone padrão.
	 *
	 * @return string
	 */
	public function defaultIcon() : string
	{
		return Storage::url($this->getRootFolder() . '/_default.png');
	}


	/**
	 * Apaga o arquivo do ícone.
	 *
	 * @return void
	 */
	public function deleteIcon() : void
	{
		if ($this->icon_path)
		{
			Storage::disk('public')->delete($this->iconPath());
			$this->icon_path = null;
		}
	}
}
