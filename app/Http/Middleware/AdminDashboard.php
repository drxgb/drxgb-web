<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
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
		/** @var User */
		$user = $request->user();
		if (!$user || !$user->isAdmin())
			abort(403);

		Inertia::share('emailInboxUrl', config('app.inbox_url'));
		Inertia::share('navLinks', $this->shareNavLinks($request));

        return $next($request);
    }


	/**
	 * Insere os links de navegação do painel administrativo.
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	protected function shareNavLinks(Request $request): array
	{
		return [
			// Dashboard
			[
				'icon'	=> 'gauge',
				'key'	=> 'dashboard',
				'href'	=> route('admin.index'),
			],

			// Arquivos
			[
				'icon'	=> 'file',
				'key'	=> 'nav.files',
				'items'	=> [
					[
						'key'	=> 'nav.file_extensions',
						'href'	=> route('admin.file-extensions.index'),
					],
					[
						'key'	=> 'nav.platforms',
						'href'	=> '',
					],
				],
			],

			// Example Item
			/* [
				'icon'	=> 'user',						// Ícone do Font Awesome
				'key'	=> '',							// Chave do texto para tradução
				'title'	=> 'Item',						// Nome do item (não use esta chave se possuir a 'key', senão será sobrescrita)
				'href'	=> route('admin.index'),		// Link do item
				'items'	=> [],							// Um conjunto de itens desta seção. A estrutura do array é a mesma desta.
			], */
		];
	}
}
