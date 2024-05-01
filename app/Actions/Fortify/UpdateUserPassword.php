<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     */
    public function update(\Illuminate\Foundation\Auth\User $user, array $input): void
    {
		/** @var array<string, mixed> */
		$rules = [
            'current_password' => [ 'string', 'current_password:web' ],
            'password' => $this->passwordRules(),
        ];
		/** @var array<string, string> */
		$messages = [
            'current_password.current_password' => __('passwords.not_matched'),
			'password.confirmed'				=> __('passwords.confirm'),
        ];

		if (is_null($input ['current_password']))
			$input['current_password'] = '';

        Validator::make($input, $rules, $messages)->validateWithBag('updatePassword');
        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
