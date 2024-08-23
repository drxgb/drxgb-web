<?php

namespace App\Services\FileExtension;

use App\Services\Service;
use App\Services\MustSave;
use App\Contracts\Saveable;
use App\Services\SingleFile;
use App\Models\FileExtension;
use App\Events\StoreableUpdated;
use App\Services\MustDeleteSingleFile;


class EditorService extends Service implements Saveable
{
	use SingleFile;
	use MustSave;
	use MustDeleteSingleFile;


	/**
	 * A instância da extensão de arquivo.
	 *
	 * @var FileExtension
	 */
	protected $fileExtension;


	/**
	 * @param FileExtension $fileExtension
	 */
	public function __construct(FileExtension $fileExtension)
	{
		parent::__construct();
		$this->fileExtension = $fileExtension;
	}


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
		$key = $fileExtension->getPathFieldName();

		tap($fileExtension->$key, function (?string $previous) use ($fileExtension) : void
		{
			$fileExtension->save();

			if (! $this->cleanUnusedFile($fileExtension, $previous))
			{
				$this->saveFile($fileExtension, $fileExtension->extension);
				StoreableUpdated::dispatch($fileExtension);
			}
		});

		return $fileExtension;
	}
}
