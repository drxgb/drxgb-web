<?php

namespace App\Services\Version;

use App\Contracts\Deletable;
use App\Models\ProductFile;
use App\Models\Version;
use App\Services\MustDelete;
use App\Services\Service;


/**
 * Responsável por deletar a versão.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
class DeleterService extends Service implements Deletable
{
	use MustDelete;


	/**
	 * O modelo da versão.
	 *
	 * @var Version
	 */
	protected $version;


	/**
	 * @param Version $version
	 */
	public function __construct(Version $version)
	{
		parent::__construct();
		$this->version = $version;
	}


	/**
	 * @return mixed
	 */
	protected function onDelete() : mixed
	{
		foreach ($this->version->productFiles as $productFile)
		{
			/** @var ProductFile $productFile */
			app(\App\Services\ProductFile\DeleterService::class, compact('productFile'))
				->delete();
		}

		$this->version->delete();
		return true;
	}
}
