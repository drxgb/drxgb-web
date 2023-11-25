<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		/** @var User */
		$user = auth()->user();
		/** @var Session */
		$session = $request->session();
		/** @var string */
		$key = 'locale';

		if ($user)
			app()->setLocale($user->language->locale);
		else if ($session->has($key))
			app()->setLocale($session->get($key));
		else if ($request->hasCookie($key))
			app()->setLocale($request->cookie($key));

        return $next($request);
    }
}
