<?php

namespace App\Builders;

use App\Builders\Builder;


class BreadcrumbBuilder extends Builder
{
	/**
	 * Limpa o resultado da construção
	 * @return void
	 */
	public function clear() : void
	{
		$this->result = [];
	}


	/**
	 * Monta as migalhas de pão de acordo com o caminho da URI.
	 * @param string $path
	 * @return void
	 */
	public function makeFromPath(string $path) : void
	{
		$data = $this->getData();
		$paths = explode('/', trim($path, '/ \x00'));
		$last = end($paths);
		$this->clear();

		foreach ($paths as $p)
		{
			if (array_key_exists($p, $data))
			{
				if ($p !== $last)
					$this->result[] = $data[$p];
				else
					$this->result[]['label'] = $data[$p]['label'];
			}
		}
	}


	/**
	 * Recebe os dados da migalha de pão.
	 * @return array
	 */
	private function getData() : array
	{
		return array_map(
			function (array $item) : array
			{
				$item['label'] = __($item['label']);
				if (isset($item['url']))
				{
					if (!isset($item['literal']) || !$item['literal'])
						$item['url'] = route($item['url']);
				}

				return $item;
			},
			config('breadcrumbs')
		);
	}
}
