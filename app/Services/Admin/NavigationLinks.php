<?php

namespace App\Services\Admin;


/**
 * Responsável por tratar os links de navegação do painel administrativo.
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
class NavigationLinks
{
	/**
	 * Recebe a lista de links de navegação.
	 * @return array
	 */
	public function get() : array
	{
		return array_map(
			fn (array $item) : array => self::hydrateItem($item),
			config('admin.nav_links')
		);
	}


	/**
	 * Callback para capturar nomes de rotas e transformá-las.
	 * @param array $item
	 * @return array
	 */
	private static function hydrateItem(array $item) : array
	{
		// Hidratar subgrupo
		if (isset($item['items']))
		{
			$item['items'] = array_map(
				fn (array $i) : array => self::hydrateItem($i),
				$item['items']
			);
		}

		// Traduzir título
		if (isset($item['title']))
			$item['title'] = __($item['title']);

		// Transformar rota em URL
		if (isset($item['href']))
		{
			if (!isset($item['literal']) || !$item['literal'])
				$item['href'] = route($item['href']);

			$pattern = '#^' . $item['href'] . '.*#';
			if (preg_match($pattern, request()->fullUrl()))
				$item['active'] = true;
		}

		return $item;
	}
}
