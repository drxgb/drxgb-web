<?php

namespace App\Http\Requests;

use App\Models\Platform;
use App\Rules\SupportedFileExtensions;


class VersionRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        return [
            'number'						=> 'required|numeric',
			'fixes'							=> 'nullable|string',
			'release_notes'					=> 'nullable|string',
			'release_date'					=> 'required|date',
			'version_files'					=> 'required|array|min:1',
			'version_files.*.product_file'	=> 'required|file',
			'version_files.*.name'			=> 'nullable|string',
			'version_files.*.platform_ids'	=> 'required|array|min:1',
        ] + $this->extensionRules();
    }


	/**
	 * Recebe as regras da extensão de arquivo.
	 * @return array
	 */
	private function extensionRules() : array
	{
		foreach ($this->version_files as $f => $file)
		{
			if (isset($files['platform_ids']))
			{
				$supportedExtensions = [];
				$platforms = Platform::whereIn('id', $file['platform_ids'])->get();

				foreach ($platforms as $platform)
				{
					/** @var Platform $platform */
					array_push($supportedExtensions, ...$platform->fileExtensionsList());
				}

				$rules["version_files.$f.file"] = [
					'required',
					new SupportedFileExtensions(array_unique($supportedExtensions)),
				];
			}
		}

		return $rules ?? [];
	}
}
