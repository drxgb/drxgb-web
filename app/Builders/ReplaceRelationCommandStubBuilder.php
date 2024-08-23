<?php

namespace App\Builders;


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
		$command = $this->command;
		$type = $command->option('relation');
		$stub = $this->getPartStub("relation.{$type}");

		return $this->makeReplacementParts($stub);
	}
}
