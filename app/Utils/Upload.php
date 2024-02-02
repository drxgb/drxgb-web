<?php

namespace App\Utils;


abstract class Upload
{
	/**
	 * Monta o caminho com a estrutura padrão das subpastas de acordo com o ID.
	 * @param string $basePath
	 * @param mixed $id
	 * @param string $filename
	 * @return string
	 */
	public static function makePath(string $basePath, ?int $id = null, ?string $filename = null) : string
	{
		if (!is_null($id))
		{
			return sprintf('%s/%d/%d/%s',
				$basePath,
				floor($id / 1000),
				$id,
				$filename
			);
		}

		return "$basePath/$filename";
	}
}
