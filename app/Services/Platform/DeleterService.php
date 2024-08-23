<?php

namespace App\Services\Platform;

use App\Contracts\Deletable;
use App\Models\Platform;
use App\Services\MustDelete;
use App\Services\MustDeleteSingleFile;
use App\Services\Service;


/**
 * Responsável por deletar.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
class DeleterService extends Service implements Deletable
{
	use MustDelete;
	use MustDeleteSingleFile;


	/**
	 * O modelo da plataform.
	 *
	 * @var Platform
	 */
	protected $platform;


	/**
	 * @param Platform $platform
	 */
	public function __construct(Platform $platform)
	{
		parent::__construct();
		$this->platform = $platform;
	}


	/**
	 * @return bool
	 */
	protected function onDelete() : bool
	{
		$result = $this->platform->delete();
		$this->deleteFile($this->platform);

		return $result;
	}
}
