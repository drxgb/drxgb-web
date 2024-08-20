<?php

namespace App\Services\FileExtension;

use App\Contracts\Saveable;
use App\Models\FileExtension;
use App\Services\MustDeleteSingleFile;
use App\Services\MustSave;
use App\Services\Service;
use App\Services\SingleUpload;


class EditorService extends Service implements Saveable
{
	use SingleUpload;
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
		$key = $fileExtension->getFileFieldName();

		tap($fileExtension->$key, function (?string $previous) use ($fileExtension) : void
		{
			$fileExtension->save();

			if ($this->deleteFile)
			{
				$this->deleteFile($fileExtension, $previous);
			}
			else
			{
				$this->saveUpload($fileExtension, $fileExtension->extension);
			}
		});

		return $fileExtension;
	}
}
