<?php

namespace App\Services\Version;

use App\Models\Version;
use App\Models\Platform;
use App\Services\Service;
use App\Services\MustSave;
use App\Contracts\Saveable;
use App\Contracts\Assignable;
use App\Contracts\Associatable;
use App\Services\MustAssociate;
use Illuminate\Http\UploadedFile;
use App\Contracts\Disassociatable;
use App\Services\MustAssignMultiple;
use Illuminate\Database\Eloquent\Builder;
use App\Exceptions\DisassociationException;

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
	use VersionCommonActionsTrait;


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
			/** @var UploadedFile */
			$upload = $file['product_file'];
			$name = $file['name'] ?? null;
			$platforms = $this->getPlatforms($file['platform_ids']);
			$attributes = $this->hydratateAttributes($name, $upload);

			$productFiles[] = app(\App\Services\ProductFile\CreatorService::class)
				->fill($attributes)
				->attach($platforms)
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
