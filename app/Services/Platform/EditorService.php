<?php

namespace App\Services\Platform;

use App\Contracts\Saveable;
use App\Contracts\Syncable;
use App\Events\StoreableUpdated;
use App\Models\Platform;
use App\Services\MustDeleteSingleFile;
use App\Services\MustSave;
use App\Services\MustSync;
use App\Services\Service;
use App\Services\SingleFile;


class EditorService extends Service implements Saveable, Syncable
{
	use MustDeleteSingleFile;
	use MustSave;
	use MustSync;
	use SingleFile;


	/**
	 * A instância da extensão de arquivo.
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
	 * @param array $attributes
	 * @return static
	 */
	#[\Override]
	public function fill(array $attributes) : static
	{
		$this->platform->fill($attributes);
		return $this;
	}


	/**
	 * @return Platform
	 */
	protected function onSave() : Platform
	{
		$platform = $this->platform;
		$key = $platform->getFileFieldName();

		tap($platform->$key, function (?string $previous) use ($platform) : void
		{
			$platform->save();

			if (! $this->cleanUnusedFile($platform, $previous))
			{
				$this->saveFile($platform, $platform->short_name);
				StoreableUpdated::dispatch($platform);
			}
		});

		return $platform;
	}


	/**
	 * @param mixed $data
	 * @return void
	 */
	protected function onSync(mixed $data) : void
	{
		$this->platform->fileExtensions()->sync($data);
	}
}
