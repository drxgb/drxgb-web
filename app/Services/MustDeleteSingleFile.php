<?php

namespace App\Services;

use App\Contracts\Storeable;
use Illuminate\Support\Facades\Storage;

trait MustDeleteSingleFile
{
	/**
	 * Sinaliza que o arquivo precisa ser deletado.
	 *
	 * @var boolean
	 */
	protected $deleteFile = false;


	/**
	 * Determina se o arquivo deve ser deletado.
	 *
	 * @param boolean $delete
	 * @return static
	 */
	public function mustDelete(bool $delete = true) : static
	{
		$this->deleteFile = $delete;
		return $this;
	}


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


	/**
	 * Retira o arquivo que não possui mais vínculo com o modelo.
	 *
	 * @param Storeable $storable
	 * @param ?string $filename
	 * @return boolean
	 */
	protected function cleanUnusedFile(Storeable $storable, ?string $filename) : bool
	{
		$disk = Storage::disk($storable->getFileDisk());

		if ($filename && ($disk->exists($filename) || $this->deleteFile))
		{
			$this->deleteFile($storable, $filename);
			return true;
		}

		return false;
	}
}
