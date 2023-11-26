<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthenticateLoginAttempt
{
	public function passed(Request $request)
	{
		/** @var User */
		$user = User::where('email', $request->name)
			->orWhere('name', $request->name)
			->first();

		if ($user && Hash::check($request->password, $user->password))
		{
			return $user;
		}
	}
}
