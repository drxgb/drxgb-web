<?php

namespace App\Builders;

use InvalidArgumentException;

use function Laravel\Prompts\confirm;


/**
 * Responsável por construir as subsituições de arquivo aplicando
 * modelos à classe na qual está sendo gerada por comando Artisan.
 *
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
class ReplaceModelCommandStubBuilder extends CommandStubBuilder
{
	/**
	 * @return array
	 */
	protected function buildParts() : array
	{
		$command = $this->command;
		$modelClass = $this->onBeforeReplace->call($command, $command->option('model'));

		if (! class_exists($modelClass) &&
			confirm("A {$modelClass} model does not exist. Do you want to generate it?")
		)
		{
			$command->call('make:model', ['name' => $modelClass]);
		}

		$model = class_basename($modelClass);
		$modelProperty = lcfirst($model);
		$stub = $this->getPartStub("model.{$command->option('type')}");

		$searches = [
			[ 'DummyModelNamespace', 'DummyModelClass', 'DummyModelProperty' ],
			[ '{{ modelNamespace }}', '{{ modelClass }}', '{{ modelProperty }}' ],
			[ '{{modelNamespace}}', '{{modelClass}}', '{{modelProperty}}' ],
		];
		$replaces = [ $modelClass, $model, $modelProperty ];

		foreach ($searches as $search)
		{
			$stub = str_replace($search, $replaces, $stub);
		}

		return $this->makeReplacementParts($stub);
	}


	/**
	 * Recebe o nome da classe de modelo qualificada.
	 *
	 * @param  string  $model
	 * @return string
	 *
	 * @throws \InvalidArgumentException
	 */
	protected function parseModel(string $model) : string
	{
		if (preg_match('([^A-Za-z0-9_/\\\\])', $model))
		{
			throw new InvalidArgumentException('Model name contains invalid characters.');
		}

		return $this->command->qualifyModel($model);
	}
}
