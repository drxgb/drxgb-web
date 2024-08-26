<?php

namespace App\Services\Product;

use App\Contracts\Assignable;
use App\Contracts\Saveable;
use App\Models\Product;
use App\Services\MultipleFiles;
use App\Services\MustAssignMultiple;
use App\Services\MustSave;
use App\Services\Service;
use App\Services\ShouldRefresh;


/**
 * Responsável por criar.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
class CreatorService extends Service implements Saveable, Assignable

{
	use MustSave;
	use MultipleFiles;
	use MustAssignMultiple;
	use ShouldRefresh;


	/**
	 * O modelo.
	 *
	 * @var Product
	 */
	protected $product;


	/**
	 * @param array $attributes
	 * @return static
	 */
	#[\Override]
	public function fill(array $attributes) : static
	{
		$this->product->fill($attributes);
		return $this;
	}


	/**
	 * @return mixed
	 */
	protected function onSave() : mixed
	{
		$product = $this->product;
		$product->save();
		$this->applyAssignment();

		if ($this->refresh)
		{
			$product->refresh();
		}

		return $product;
	}


	/**
	 * @return void
	 */
	#[\Override]
	protected function setup() : void
	{
		$this->product = new Product;
	}


	/**
	 * @param mixed $data
	 * @return void
	 */
	protected function onAssign(mixed $data) : void
	{
		$this->product->versions()->createMany($data);
	}
}
