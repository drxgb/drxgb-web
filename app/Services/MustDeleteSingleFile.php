<?php

namespace App\Services;

use App\Contracts\Storeable;

trait MustDeleteSingleFile
{
	/**
	 * Deleta o arquivo.
	 *
	 * @param Storeable $storeable
	 * @param ?string $filename
	 * @return void
	 */
	public function deleteFile(Storeable $storeable, ?string $filename = null) : void
	{
		$storeable->deleteFile($filename);
	}
}
