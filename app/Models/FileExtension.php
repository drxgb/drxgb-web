<?php

namespace App\Models;

use App\Contracts\Iconable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileExtension extends Model
	implements Iconable
{
    use HasFactory, HasIcon;

	protected $fillable = [
		'name',
		'extension',
		'icon_path',
	];

	protected $appends = [
		'icon',
	];


	/**
	 * Recebe a pasta raiz do conteúdo.
	 *
	 * @return string
	 */
	public function getRootFolder() : string
	{
		return 'extension-icon';
	}


	/**
	 * Recebe o nome do arquivo que representaria o conteúdo.
	 *
	 * @return string
	 */
	public function getFileName() : string
	{
		return $this->extension;
	}
}
