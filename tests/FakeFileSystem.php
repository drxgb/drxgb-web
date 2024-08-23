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


	/**
	 * Recebe o tipo do disco onde serão armazenados
	 * os arquivos de teste.
	 *
	 * @return string
	 */
	protected function getDisk() : string
	{
		return 'public';
	}


	/**
	 * Inicializa a simulação do sistema de arquivos.
	 *
	 * @return void
	 */
	private function setupFileSystem() : void
	{
		$disk = $this->getDisk();

		Storage::fake($disk);
		$this->fs = Storage::disk($disk);
	}
}
