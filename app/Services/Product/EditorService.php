<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\Category;
use App\Services\Service;
use App\Services\MustSave;
use App\Contracts\Saveable;
use App\Contracts\Assignable;
use App\Contracts\Associatable;
use App\Services\MultipleFiles;
use App\Services\MustAssociate;
use App\Contracts\Disassociatable;
use App\Models\Version;
use App\Services\MustAssignMultiple;
use App\Services\MustDeleteMultipleFiles;
use App\Services\ShouldRefresh;


/**
 * Responsável por editar o produto.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
class EditorService extends Service implements Saveable, Assignable, Associatable, Disassociatable
{
	use MustSave;
	use MultipleFiles;
	use MustDeleteMultipleFiles;
	use MustAssignMultiple;
	use MustAssociate;
	use ProductCommonActionsTrait;
	use ShouldRefresh;


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
		$this->cleanUnusedFiles($product, count($this->uploadedFiles));

		if ($this->refresh)
		{
			$product->refresh();
		}

		return $product;
	}


	/**
	 * @param mixed $data
	 * @return void
	 */
	protected function onAssign(mixed $data) : void
	{
		$product = $this->product;

		foreach ($data as $versionData)
		{
			$attributes = $this->hydratateVersionAttributes($versionData);
			$files = $versionData['files'];

			if (isset($versionData['id']))
			{
				$version = Version::find($versionData['id']);

				app(\App\Services\Version\EditorService::class, compact('version'))
					->fill($attributes)
					->assign($files)
					->save();
			}
			else
			{
				$version = app(\App\Services\Version\CreatorService::class)
					->fill($attributes)
					->assign($files)
					->associate($product)
					->save();
			}

			$versions[] = $version;
		}

		$this->pruneUnusedVersions($versions);

		if (! empty($versions))
		{
			$product->versions()->saveMany($versions);
		}
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
	 * @param mixed $data
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


	/**
	 * Limpa as versões que não estão sendo mais usados pelo produto.
	 *
	 * @param array $versions
	 * @return void
	 */
	private function pruneUnusedVersions(array $versions) : void
	{
		$product = $this->product;
		$ids = array_map(fn (Version $v) : int => $v->id, $versions);
		$unusedVersions = $product->versions->except($ids);

		foreach ($unusedVersions as $version)
		{
			app(\App\Services\Version\DeleterService::class, compact('version'))
				->delete();
		}
	}
}
