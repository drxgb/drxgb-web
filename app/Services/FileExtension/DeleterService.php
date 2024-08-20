<?php

namespace App\Services\FileExtension;

use App\Services\MustDelete;
use App\Services\Service;
use App\Models\FileExtension;
use App\Services\MustDeleteSingleFile;

class DeleterService extends Service
{
	use MustDelete;
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
	 * @return boolean
	 */
	protected function onDelete() : bool
	{
		$result = $this->fileExtension->delete();
		$this->deleteFile($this->fileExtension);

		return $result;
	}
}
