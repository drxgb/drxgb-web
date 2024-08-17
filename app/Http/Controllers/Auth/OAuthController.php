<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\Languages;
use App\Utils\Strings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;

class OAuthController extends Controller
{
    /**
	 * Ação de redirecionamento.
	 *
	 * @return RedirectResponse
	 */
	public function redirect(string $provider) : RedirectResponse
	{
		/** @var AbstractProvider */
		$driver = Socialite::driver($provider);
		return $driver->stateless()->redirect();
	}


	/**
	 * Acão de callback.
	 *
	 * @return RedirectResponse
	 */
	public function callback(Request $request, string $provider) : RedirectResponse
	{
		try
		{
			/** @var AbstractProvider */
			$driver = Socialite::driver($provider);
			$socialUser = $driver->stateless()->user();
			$builder = User::where('email', $socialUser->getEmail());

			if ($builder->exists())
			{
				$user = $builder->first();
			}
			else
			{
				$language = Languages::getFromLocale();
				$user = User::create([
					'name'					=> Strings::makeUserNameFromEmail($socialUser->getEmail()),
					'display_name'			=> $socialUser->getName(),
					'email'					=> $socialUser->getEmail(),
					'language_id'			=> $language->id ?? 1,
					'role_id'				=> 2,
					'profile_photo_path'	=> $socialUser->getAvatar(),
					'provider'				=> $provider,
					'provider_id'			=> $socialUser->getId(),
					'provider_token'		=> $socialUser->token,
				]);
			}

			auth()->login($user);
			return to_route('home');
		}
		catch (\Exception $e)
		{
			return to_route('login');
		}

	}
}
