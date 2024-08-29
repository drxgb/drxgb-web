<?php

namespace App\Services\ProductFile;

use App\Models\FileExtension;

trait ValidateProductFileTrait
{
	/**
	 * Verifica a validação de uma extnesão de arquivo do produto.
	 *
	 * @param array $platforms
	 * @param array $errors
	 * @return void
	 */
	protected function validateFileExtension(array $platforms, array &$errors) : void
	{
		$upload = $this->getUploadedFile();
		$extension = $upload->getClientOriginalExtension();
		$fileExtensions = [];

		foreach ($platforms as $platform)
		{
			$fileExtensions = array_replace(
				$fileExtensions,
				array_map(
					fn (FileExtension $ext) : string => $ext->extension,
					$platform['supported_file_extensions']
				)
			);
		}

		if (! in_array($extension, $fileExtensions))
		{
			$errors[] = __('validation.supported_file_extensions', [
				'values'	=> implode(', ', $fileExtensions),
				'other'		=> $extension,
			]);
		}
	}
}
