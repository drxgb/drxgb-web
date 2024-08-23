<?php

namespace App\Services\FileExtension;

use App\Contracts\Saveable;
use App\Models\FileExtension;
use App\Services\MustSave;
use App\Services\Service;
use App\Services\SingleFile;


class CreatorService extends Service implements Saveable
{
	use SingleFile;
	use MustSave;


	/**
	 * A instância da extensão de arquivo.
	 *
	 * @var FileExtension
	 */
	protected $fileExtension;


	/**
	 * @param array $attributes
	 * @return static
	 */
	#[\Override]
	public function fill(array $attributes) : static
	{
		$this->fileExtension->fill($attributes);
		return $this;
	}


	/**
	 * @return FileExtension
	 */
	protected function onSave() : FileExtension
	{
		$fileExtension = $this->fileExtension;
		$fileExtension->save();
		$this->saveFile($fileExtension, $fileExtension->extension);

		return $fileExtension;
	}


	/**
	 * @return void
	 */
	#[\Override]
	protected function setup() : void
	{
		$this->fileExtension = new FileExtension;
	}
}
