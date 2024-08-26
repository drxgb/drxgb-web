<?php

namespace App\Services\ProductFile;

use App\Services\Service;
use App\Services\MustSave;
use App\Contracts\Saveable;
use App\Models\ProductFile;
use App\Services\SingleFile;
use App\Contracts\Associatable;
use App\Services\MustAssociate;
use App\Contracts\Disassociatable;
use App\Exceptions\DisassociationException;


/**
 * Responsável por criar o arquivo do produto.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
class CreatorService extends Service implements Saveable, Associatable, Disassociatable
{
	use MustSave;
	use SingleFile;
	use MustAssociate;


	/**
	 * O modelo do arquivo do produto.
	 *
	 * @var ProductFile
	 */
	protected $productFile;


	/**
	 * @param array $attributes
	 * @return static
	 */
	#[\Override]
	public function fill(array $attributes) : static
	{
		$this->productFile->fill($attributes);
		return $this;
	}


	/**
	 * @return mixed
	 */
	protected function onSave() : mixed
	{
		$productFile = $this->productFile;
		$upload = $this->getUploadedFile();

		if ($this->hasUpload())
		{
			$productFile->forceFill([
				'extension'		=> $upload->getClientOriginalExtension(),
				'size'			=> $upload->getSize(),
			]);
		}

		$this->applyAssociation();
		$productFile->save();
		$this->saveFile($productFile, $productFile->name);

		return $productFile;
	}


	/**
	 * @return void
	 */
	#[\Override]
	protected function setup() : void
	{
		$this->productFile = new ProductFile;
	}


	/**
	 * @param mixed $data
	 * @return void
	 */
	protected function onAssociate(mixed $data) : void
	{
		$this->productFile->version()->associate($data);
	}


	/**
	 * @param mixed $data
	 * @return void
	 */
	protected function onDisassociate() : void
	{
		throw new DisassociationException;
	}
}
