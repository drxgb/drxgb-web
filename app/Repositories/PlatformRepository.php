<?php

namespace App\Repositories;

use App\Models\FileExtension;


class PlatformRepository
{
	use HasIcon;

	/**
	 * Recebe a lista das extensões em ordem alfabética.
	 *
	 * @param ?string $sort
	 * @return array<FileExtension>
	 */
	public function extensions(?string $sort = null) : array
	{
		$extensions = FileExtension::all();
		if ($sort)
		{
			$extensions = $extensions->sortBy($sort);
		}

		return array_values($extensions->toArray());
	}
}
