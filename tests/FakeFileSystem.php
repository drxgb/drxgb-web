<?php

namespace Tests;

use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;


trait FakeFileSystem
{
	/**
	 * O adaptador do sistema de arquivos.
	 *
	 * @var FilesystemAdapter
	 */
	private $fs;


	private function setupFileSystem() : void
	{
		$disk = config('filesystems.test_disk', 'local-test');

		Storage::fake($disk);
		$this->fs = Storage::disk($disk);
	}
}
