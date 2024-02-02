<?php

namespace App\Http\Requests;


class ProductRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'			=> 'required|string|max:60',
			'slug'			=> 'required|string|max:60',
			'page'			=> 'nullable|string',
			'description'	=> 'nullable|string',
			'price'			=> 'required|numeric|min:0',
			'active'		=> 'boolean',
			'cover_index'	=> 'nullable|numeric',

			'category_id'	=> 'nullable',
			'versions'		=> 'required|array',
			'images'		=> 'nullable|array',

			'versions.*.number'					=> 'required|numeric',
			'versions.*.release_date'			=> 'required|date',
			'versions.*.release_notes'			=> 'nullable',
			'versions.*.fixes'					=> 'nullable',
			'versions.*.files'					=> 'required|array',
			'versions.*.files.*.name'			=> 'nullable',
			'versions.*.files.*.platform_ids'	=> 'required|array',
			'versions.*.files.*.product_file'	=> 'required|file',
        ];
    }
}
