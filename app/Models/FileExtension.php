<?php

namespace App\Models;

use App\Contracts\Iconable;
use App\Contracts\Storeable;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileExtension extends Model
	implements Iconable, Storeable
{
    use HasFactory;

	protected $fillable = [
		'name',
		'extension',
		'icon_path',
	];

	protected $appends = [
		'icon',
	];


	/**
	 * Recebe a imagem do ícone da extensão.
	 * @return Attribute
	 */
	public function icon() : Attribute
	{
		return Attribute::get(function () : string {
			return ($this->icon_path)
				? Storage::url($this->getRootFolder() . '/' . $this->icon_path)
				: $this->defaultIcon();
		});
	}


	/**
	 * Salva o arquivo do ícone.
	 * @param UploadedFile $upload
	 * @return void
	 */
	public function saveIcon(UploadedFile $upload) : void
	{
		$imgExtension = $upload->extension();
		$filename = $this->extension . '.' . $imgExtension;
		$upload->storePubliclyAs($this->getRootFolder(), $filename, 'public');
		$this->icon_path = $filename;
	}


	/**
	 * O caminho do arquivo do ícone padrão.
	 * @return string
	 */
	public function defaultIcon() : string
	{
		return Storage::url($this->getRootFolder() . '/_default.png');
	}


	/**
	 * Apaga o arquivo do ícone.
	 * @return void
	 */
	public function deleteIcon() : void
	{
		if ($this->icon_path)
		{
			Storage::disk('public')->delete($this->getRootFolder() . '/' . $this->icon_path);
			$this->icon_path = null;
		}
	}


	/**
	 * Recebe a pasta raiz do conteúdo.
	 * @return string
	 */
	public function getRootFolder() : string
	{
		return 'extension-icon';
	}
}
