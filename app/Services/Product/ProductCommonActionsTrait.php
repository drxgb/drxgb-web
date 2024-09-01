<?php

namespace App\Services\Product;


trait ProductCommonActionsTrait
{
	/**
	 * Hidrata os atributos da versão.
	 *
	 * @param array $version
	 * @return array
	 */
	protected function hydratateVersionAttributes(array $version) : array
	{
		return array_filter(
			$version,
			fn (string $k) : bool =>
				$k === 'number' ||
				$k === 'release_date' ||
				$k === 'release_notes' ||
				$k === 'fixes',
			ARRAY_FILTER_USE_KEY
		);
	}
}
