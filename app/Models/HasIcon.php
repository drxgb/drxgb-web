<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;


trait HasIcon
{
	/**
	 * @return string
	 */
	public function getPathFieldName() : string
	{
		return 'icon_path';
	}


	/**
	 * @return string
	 */
	public function getFileExtension() : string
	{
		return 'gif';
	}


	/**
	 * Recebe a imagem do ícone da extensão.
	 *
	 * @return Attribute
	 */
	public function icon() : Attribute
	{
		return Attribute::get(fn () : string =>
			Storage::url(
				$this->icon_path
					? $this->getFullFileName()
					: $this->getDefaultFileName()
			)
		);
	}
}
