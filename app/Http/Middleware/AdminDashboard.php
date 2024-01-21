<?php

namespace App\Http\Middleware;

use App\Services\Admin\NavigationLinks;
use Closure;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trata as páginas que possuem apenas acesso para usuários que usam de
 * algum privilégio administrativo para acessar.
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
class AdminDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		$user = $request->user();
		if (!$user || !$user->isAdmin())
			abort(403);

		$navLinks = App::make(NavigationLinks::class);

		Inertia::share('emailInboxUrl', config('admin.inbox_url'));
		Inertia::share('navLinks', $navLinks->get());

        return $next($request);
    }
}
