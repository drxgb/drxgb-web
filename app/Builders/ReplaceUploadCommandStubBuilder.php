<?php

namespace App\Builders;


/**
 * Responsável por construir as subsituições de arquivo aplicando
 * as funções de upload à classe na qual está sendo gerada por
 * comando Artisan.
 *
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
class ReplaceUploadCommandStubBuilder extends CommandStubBuilder
{
	/**
	 * @return array
	 */
	protected function buildParts() : array
	{
		$command = $this->command;
		$uploadType = $command->option('upload');

		switch ($uploadType)
		{
			case 'multiple';
				$uploadType .= 'Files';
				break;

			default:
				$uploadType .= 'File';
		}
		$uploadType = ucfirst($uploadType);

		$stub = $this->getPartStub("upload.{$command->option('type')}");
		$stub = str_replace("{{ uploadType }}", $uploadType, $stub);

		return $this->makeReplacementParts($stub);
	}
}
