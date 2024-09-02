<?php

namespace App\Http\Requests;


class StoreFileExtensionRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        return [
            'name'		=> 'required|max:255',
			'extension'	=> 'required|unique:file_extensions',
			'icon'		=> 'nullable|image|dimensions:width=16,height=16',
        ];
    }
}
