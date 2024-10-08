<?php

namespace App\Services\FileExtension;

use App\Contracts\Deletable;
use App\Services\MustDelete;
use App\Services\Service;
use App\Models\FileExtension;
use App\Services\MustDeleteSingleFile;


class DeleterService extends Service implements Deletable
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
	 * @return mixed
	 */
	protected function onDelete() : mixed
	{
		$result = $this->fileExtension->delete();
		$this->deleteFile($this->fileExtension);

		return $result;
	}
}
