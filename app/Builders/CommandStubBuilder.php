<?php

namespace App\Builders;

use App\Builders\Builder;
use Closure;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;


/**
 * Responsável por construir o arquivo modelo de um comando Artisan.
 *
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
abstract class CommandStubBuilder extends Builder
{
	/**
	 * Callback da ação chamada antes da substituição
	 * dos dados.
	 *
	 * @var Closure
	 */
	protected $onBeforeReplace;


	/**
	 * @param GeneratorCommand $command
	 * @param Filesystem $files
	 */
	public function __construct(
		protected GeneratorCommand $command,
		protected Filesystem $files,
		protected string $context = 'services'
	)
	{
		parent::__construct();
	}


	/**
	 * Limpa o resultado da construção.
	 *
	 * @return void
	 */
	public function clear() : void
	{
		$this->result = '';
	}


	/**
	 * Constrói as substituições do conteúdo.
	 *
	 * @param string $content
	 * @return static
	 */
	public function buildReplacements(string $content) : static
	{
		$parts = $this->buildParts();

		foreach ($parts as $point => $replace)
		{
			$this->writeFromPoint($point, $replace, $content);
		}

		$this->result = $content;

		return $this;
	}


	/**
	 * Define a ação a ser chamada antes de realizar a substituição.
	 *
	 * @param Closure $callback
	 * @return static
	 */
	public function beforeReplace(Closure $callback) : static
	{
		$this->onBeforeReplace = $callback;
		return $this;
	}


	/**
	 * Recebe a parte do conteúdo a ser substituído.
	 *
	 * @param string $name
	 * @return string
	 */
	protected function getPartStub(string $name) : string
	{
		$command = $this->command;
		$base = $this->getStubBasePath();
		$stub = "$base/$name.stub";
		$path = $command->resolveStubPath($stub);

		return $this->files->get($path);
	}


	/**
	 * Escreve o conteúdo a partir do ponto do documento.
	 *
	 * @param string $point
	 * @param string $replace
	 * @param string $content
	 * @return string
	 */
	protected function writeFromPoint(string $point, string $replace, string &$content) : string
	{
		$content = str_replace($point, "{$replace}{$point}", $content);
		return $content;
	}


	/**
	 * Cria as partes do documento de reposição.
	 *
	 * @param string $stub
	 * @return array
	 */
	protected function makeReplacementParts(string $stub) : array
	{
		$pattern = '/\{\{ \#[A-Za-z0-9-_]+ \}\}\r?\n/im';
		$parts = preg_split($pattern, $stub, flags: PREG_SPLIT_NO_EMPTY);
		preg_match_all($pattern, $stub, $points);

		return array_combine($points[0], $parts);
	}


	/**
	 * @return string
	 */
	protected function getStubBasePath() : string
	{
		return "/stubs/{$this->context}/parts";
	}


	/**
	 * Constrói as partes a serem substituídas.
	 *
	 * @return array
	 */
	protected abstract function buildParts() : array;
}
