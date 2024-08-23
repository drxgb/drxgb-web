<?php

namespace App\Services\Platform;

use App\Contracts\Attachable;
use App\Contracts\Detachable;
use App\Contracts\Saveable;
use App\Models\Platform;
use App\Services\MustAttach;
use App\Services\MustSave;
use App\Services\Service;
use App\Services\SingleFile;


class CreatorService extends Service implements Saveable, Attachable, Detachable
{
	use SingleFile;
	use MustSave;
	use MustAttach;


	/**
	 * A instância da extensão de arquivo.
	 *
	 * @var Platform
	 */
	protected $platform;


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
		$platform->save();
		$this->applyAttachments();
		$this->saveFile($platform, $platform->short_name);

		return $platform;
	}


	/**
	 * @param mixed $attachment
	 * @return void
	 */
	protected function onAttach(mixed $attachment) : void
	{
		$this->platform->fileExtensions()->attach($attachment);
	}


	/**
	 * @param mixed $data
	 * @return void
	 */
	protected function onDetach(mixed $data) : void
	{
		$this->platform->fileExtensions()->detach($data);
	}


	/**
	 * @return void
	 */
	#[\Override]
	protected function setup() : void
	{
		$this->platform = new Platform;
	}
}
