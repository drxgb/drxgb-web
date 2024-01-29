<?php

namespace App\Http\Requests;


class StoreVersionRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'number'						=> 'required|numeric',
			'fixes'							=> 'nullable|string',
			'release_notes'					=> 'nullable|string',
			'release_date'					=> 'required|date',
			'version_files'					=> 'required|array|min:1',
			'version_files.*.file'			=> 'required|file',
			'version_files.*.name'			=> 'nullable|string',
			'version_files.*.platform_ids'	=> 'required|array|min:1',
        ];
    }
}
