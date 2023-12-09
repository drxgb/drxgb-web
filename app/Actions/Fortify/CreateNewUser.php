<?php

namespace App\Actions\Fortify;

use App\Models\Language;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' 		=> ['required', 'string', 'max:255', 'unique:users'],
            'email' 	=> ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' 	=> $this->passwordRules(),
            'terms' 	=> Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

		/** @var string */
		$locale = app()->getLocale();
		/** @var Language */
		$language = Language::where('locale', $locale)->first();

        return User::create([
            'name' 			=> $input['name'],
            'email' 		=> $input['email'],
            'password' 		=> Hash::make($input['password']),
			'language_id'	=> $language->id ?? 1,
			'role_id'		=> 2,
        ]);
    }
}
