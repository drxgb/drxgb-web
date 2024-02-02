<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class SupportedFileExtensions implements ValidationRule
{
	/**
	 * @param array<string> $extensions
	 */
	public function __construct(
		private $extensions = []
	)
	{}


    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
		/** @var UploadedFile $value */
		$ext = $value->getClientOriginalExtension();
		if (!in_array($ext, $this->extensions))
		{
			$fail('validation.supported_file_extensions')->translate([
				'attribute'	=> $attribute,
				'values'	=> implode(', ', $this->extensions),
			]);
		}
    }
}
