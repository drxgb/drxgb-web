<?php

namespace App\Services\Version;

use App\Models\Platform;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;

trait VersionCommonActionsTrait
{
	/**
	 * Recupera as plataformas filtradas por ID.
	 *
	 * @param array $ids
	 * @return array
	 */
	protected function getPlatforms(array $ids) : array
	{
		return Platform::orWhere(
			function (Builder $query) use ($ids) : void
			{
				foreach ($ids as $id)
				{
					$query->orWhere('id', $id);
				}
			}
		)->get()
		->toArray();
	}


	/**
	 * Hidrata os atributos do arquivo do produto.
	 *
	 * @param string|null $name
	 * @param UploadedFile|null $upload
	 * @return array
	 */
	protected function hydratateAttributes(?string $name, ?UploadedFile $upload) : array
	{
		if (! is_null($upload))
		{
			$name ??= $upload->getClientOriginalName();
			$size = $upload->getSize();
			$attributes = compact('name', 'size');
		}
		elseif (! is_null($name))
		{
			$attributes = compact('name');
		}


		return $attributes ?? [];
	}
}
