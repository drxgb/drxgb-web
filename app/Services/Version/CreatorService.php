<?php

namespace App\Services\Version;

use App\Contracts\Assignable;
use App\Contracts\Associatable;
use App\Contracts\Disassociatable;
use App\Contracts\Saveable;
use App\Exceptions\DisassociationException;
use App\Models\Version;
use App\Services\MustAssignMultiple;
use App\Services\MustAssociate;
use App\Services\MustSave;
use App\Services\Service;


/**
 * Responsável por criar versões.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
class CreatorService extends Service implements Saveable, Assignable, Associatable, Disassociatable
{
	use MustSave;
	use MustAssignMultiple;
	use MustAssociate;


	/**
	 * O modelo da versão.
	 *
	 * @var Version
	 */
	protected $version;


	/**
	 * @param array $attributes
	 * @return static
	 */
	#[\Override]
	public function fill(array $attributes) : static
	{
		$this->version->fill($attributes);
		return $this;
	}


	/**
	 * @return mixed
	 */
	protected function onSave() : mixed
	{
		$version = $this->version;

		$this->applyAssociation();
		$version->save();

		$this->applyAssignment();
		$version->refresh();

		return $version;
	}


	/**
	 * @return void
	 */
	#[\Override]
	protected function setup() : void
	{
		$this->version = new Version;
	}


	/**
	 * @param mixed $data
	 * @return void
	 */
	protected function onAssign(mixed $data) : void
	{
		$version = $this->version;

		foreach ($data as $file)
		{
			$attributes = [ 'name'	=> $file['name'] ];
			$upload = $file['product_file'];
			$creator = app(\App\Services\ProductFile\CreatorService::class);

			$productFiles[] = $creator->fill($attributes)
				->setUploadedFile($upload)
				->associate($version)
				->save();
		}

		$version->productFiles()->saveMany($productFiles);
	}


	/**
	 * @param mixed $data
	 * @return void
	 */
	protected function onAssociate(mixed $data) : void
	{
		$this->version->product()->associate($data);
	}


	/**
	 * @param mixed $data
	 * @return void
	 */
	protected function onDisassociate() : void
	{
		throw new DisassociationException;
	}


	/**
	 * @return string|null
	 */
	protected function defaultAssignKey() : ?string
	{
		return 'files';
	}
}
