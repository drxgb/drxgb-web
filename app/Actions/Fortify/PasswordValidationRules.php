<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function passwordRules() : array
    {
		$length = config('fortify.rules.length');
		$message = __('passwords.rules', compact('length'));

		/** @var Password */
		$password = (new Password)
			->length($length)
			->requireUppercase()
			->requireNumeric()
			->requireSpecialCharacter()
			->withMessage($message);

        return [ 'required', 'string', $password, 'confirmed' ];
    }
}
