<?php

namespace App\Services\Version;

use App\Models\Version;
use App\Services\Service;
use App\Services\MustSave;
use App\Contracts\Saveable;
use App\Contracts\Assignable;
use App\Models\ProductFile;
use Illuminate\Http\UploadedFile;
use App\Services\MustAssignMultiple;


/**
 * Responsável por editar versões.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
class EditorService extends Service implements Saveable, Assignable
{
	use MustSave;
	use MustAssignMultiple;
	use VersionCommonActionsTrait;


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
		$version->save();

		$this->applyAssignment();
		$version->refresh();

		return $version;
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
			/** @var ?UploadedFile */
			$upload = $file['product_file'] ?? null;
			$name = $file['name'] ?? null;
			$attributes = $this->hydratateAttributes($name, $upload);
			$platforms = $this->getPlatforms($file['platform_ids']);

			if (isset($file['id']))
			{
				$productFile = ProductFile::find($file['id']);

				app(\App\Services\ProductFile\EditorService::class, compact('productFile'))
					->fill($attributes)
					->sync($platforms)
					->setUploadedFile($upload)
					->save();
			}
			else
			{
				$productFile = app(\App\Services\ProductFile\CreatorService::class)
					->fill($attributes)
					->attach($platforms)
					->setUploadedFile($upload)
					->associate($version)
					->save();
			}

			$productFiles[] = $productFile;
		}

		$this->pruneUnusedProductFiles($productFiles ?? []);

		if (! empty($productFiles))
		{
			$version->productFiles()->saveMany($productFiles);
		}
	}


	/**
	 * @return string|null
	 */
	protected function defaultAssignKey() : ?string
	{
		return 'files';
	}


	/**
	 * Limpa os arquivos de produtos que não estão sendo mais usados
	 * pela versão.
	 *
	 * @param array $productFiles
	 * @return void
	 */
	private function pruneUnusedProductFiles(array $productFiles) : void
	{
		$version = $this->version;
		$ids = array_map(fn (ProductFile $f) : int => $f->id, $productFiles);
		$unusedProductFiles = $version->productFiles->except($ids);

		foreach ($unusedProductFiles as $productFile)
		{
			app(\App\Services\ProductFile\DeleterService::class, compact('productFile'))
				->delete();
		}
	}
}
