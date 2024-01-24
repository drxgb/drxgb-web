<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlatformRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'				=> 'required|max:255',
			'short_name'		=> [
				'required',
				'max:24',
				Rule::unique('platforms')->ignore($this->id),
			],
			'icon'				=> 'nullable|image|dimensions:width=32,height=32',
			'file_extensions'	=> 'array',
        ];
    }
}
