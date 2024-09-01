<?php

namespace App\Services\Product;

use App\Contracts\Assignable;
use App\Contracts\Associatable;
use App\Contracts\Disassociatable;
use App\Contracts\Saveable;
use App\Models\Category;
use App\Models\Product;
use App\Services\MultipleFiles;
use App\Services\MustAssignMultiple;
use App\Services\MustAssociate;
use App\Services\MustSave;
use App\Services\Service;
use App\Services\ShouldRefresh;


/**
 * Responsável por criar produtos.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
class CreatorService extends Service implements Saveable, Assignable, Associatable, Disassociatable
{
	use MultipleFiles;
	use MustAssignMultiple;
	use MustAssociate;
	use MustSave;
	use ProductCommonActionsTrait;
	use ShouldRefresh;


	/**
	 * O modelo do produto.
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

		$this->applyAssociation();
		$product->save();
		$this->applyAssignment();
		$this->saveFiles($product);

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
		$product = $this->product;

		foreach ($data as $version)
		{
			$attributes = $this->hydratateVersionAttributes($version);
			$files = $version['files'];

			app(\App\Services\Version\CreatorService::class)
				->fill($attributes)
				->assign($files)
				->associate($product)
				->save();
		}

		$product->versions()->createMany($data);
	}


	/**
	 * @param mixed $category
	 * @return void
	 */
	protected function onAssociate(mixed $category) : void
	{
		if (is_integer($category))
		{
			$category = Category::find($category);
		}

		if (! is_null($category))
		{
			$this->product->category()->associate($category);
		}
	}


	/**
	 * @return void
	 */
	protected function onDisassociate() : void
	{
		$this->product->category()->disassociate();
	}


	/**
	 * @return string|null
	 */
	protected function defaultAssignKey() : ?string
	{
		return 'versions';
	}
}
