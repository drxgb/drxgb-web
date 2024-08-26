<?php

namespace App\Services\ProductFile;

use App\Contracts\Associatable;
use App\Contracts\Disassociatable;
use App\Contracts\Saveable;
use App\Exceptions\DisassociationException;
use App\Models\ProductFile;
use App\Services\MustAssociate;
use App\Services\MustDeleteSingleFile;
use App\Services\MustSave;
use App\Services\Service;
use App\Services\SingleFile;


/**
 * Responsável por editar o arquivo do produto.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
class EditorService extends Service implements Saveable, Associatable, Disassociatable
{
	use MustSave;
	use SingleFile;
	use MustDeleteSingleFile;
	use MustAssociate;


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
		$key = $productFile->getFileFieldName();

		tap($productFile->$key, function (?string $previous) use ($productFile) : void
		{
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

			if (! $this->cleanUnusedFile($productFile, $previous))
			{
				$this->saveFile($productFile, $productFile->name);
			}
		});

		return $productFile;
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
