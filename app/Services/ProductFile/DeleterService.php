<?php

namespace App\Services\ProductFile;

use App\Contracts\Deletable;
use App\Models\ProductFile;
use App\Services\MustDelete;
use App\Services\MustDeleteSingleFile;
use App\Services\Service;


/**
 * Responsável por deletar o arquivo do produto.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
class DeleterService extends Service implements Deletable
{
	use MustDelete;
	use MustDeleteSingleFile;


	/**
	 * O modelo do arquivo do produto.
	 *
	 * @var ProductFile
	 */
	protected $productFile;


	/**
	 * @param ProductFile $productFile
	 */
	public function __construct(ProductFile $productFile)
	{
		parent::__construct();
		$this->productFile = $productFile;
	}


	/**
	 * @return mixed
	 */
	protected function onDelete() : mixed
	{
		$result = $this->productFile->delete();
		$this->deleteFile($this->productFile);

		return $result;
	}
}
