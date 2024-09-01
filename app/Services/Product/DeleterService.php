<?php

namespace App\Services\Product;

use App\Contracts\Deletable;
use App\Models\Product;
use App\Services\MustDelete;
use App\Services\MustDeleteMultipleFiles;
use App\Services\Service;


/**
 * Responsável por deletar um produto.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
class DeleterService extends Service implements Deletable
{
	use MustDelete;
	use MustDeleteMultipleFiles;


	/**
	 * O modelo do produto.
	 *
	 * @var Product
	 */
	protected $product;


	/**
	 * @param Product $product
	 */
	public function __construct(Product $product)
	{
		parent::__construct();
		$this->product = $product;
	}


	/**
	 * @return mixed
	 */
	protected function onDelete() : mixed
	{
		$product = $this->product;
		$versions = $product->versions;

		foreach ($versions as $version)
		{
			app(\App\Services\Product\DeleterService::class, compact('version'))
				->delete();
		}

		$this->deleteFiles($product);
		$product->delete();

		return $product;
	}
}
