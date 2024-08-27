<?php

namespace App\Builders;

use App\Console\Commands\ServiceMakeCommand;

/**
 * Responsável por construir as subsituições de arquivo aplicando
 * as funções de relação de models à classe na qual está sendo
 * gerada por comando Artisan.
 *
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
class ReplaceRelationCommandStubBuilder extends CommandStubBuilder
{
	/**
	 * @return array
	 */
	protected function buildParts() : array
	{
		/** @var ServiceMakeCommand */
		$command = $this->command;
		$types = explode(',', $command->option('relation'));
		$replaces = [];

		foreach ($types as $type)
		{
			$type = trim($type);

			if (! $command->isValidOption('relation', $type))
			{
				$command->fail("'{$type}' is not a valid relation type.");
			}

			$stub = $this->getPartStub("relation.{$type}");
			$replaces = array_merge($replaces, $this->makeReplacementParts($stub));
		}

		return $replaces;
	}
}
