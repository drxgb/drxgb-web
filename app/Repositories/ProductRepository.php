<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class ProductRepository
{
	public const MOST_RELEVANT = 0;
	public const EXPENSIVER_TO_CHEAPER = 1;
	public const CHEAPER_TO_EXPENSIVER = 2;
	public const RECENT_TO_OLDER = 3;
	public const OLDER_TO_RECENT = 4;
	public const A_Z = 5;
	public const Z_A = 6;


	/**
	 * Lista dos produtos.
	 *
	 * @param array $filters
	 * @return LengthAwarePaginator|Collection
	 */
	public function list(array $filters = []) : LengthAwarePaginator|Collection
	{
		$builder = Product::select();
		$this->applyFilters($builder, $filters);

		// Mostrar por página
		if (isset($filters['p']))
			return $builder->paginate($filters['p']);

		return $builder->get();
	}


	/**
	 * Aplica os filtros para a consulta do modelo do produto.
	 *
	 * @param Builder $builder
	 * @param array $filters
	 * @return void
	 */
	private function applyFilters(Builder &$builder, array $filters) : void
	{
		// Categoria
		if (isset($filters['category']))
		{
			$categoryIds = $this->getCategoryIdsDeeply($filters['category']);
			$builder->whereIn('category_id', $categoryIds);
		}

		// Ordenar por
		if (isset($filters['o']))
		{
			switch ($filters['o'])
			{
				case self::MOST_RELEVANT:
					// TODO: Ordenar pelos mais relevantes
					break;
				case self::EXPENSIVER_TO_CHEAPER:
					$builder->orderBy('price', 'desc');
					break;
				case self::CHEAPER_TO_EXPENSIVER:
					$builder->orderBy('price', 'asc');
					break;
				case self::RECENT_TO_OLDER:
					$builder->latest();
					break;
				case self::OLDER_TO_RECENT:
					$builder->oldest();
					break;
				case self::A_Z:
					$builder->orderBy('title', 'asc');
					break;
				case self::Z_A:
					$builder->orderBy('title', 'desc');
					break;
			}
		}
	}


	/**
	 * Recebe todos os ids da categoria e das subcategorias recursivamente.
	 *
	 * @param int $id
	 * @return array
	 */
	private function getCategoryIdsDeeply(int $id) : array
	{
		$result[] = $id;
		$category = Category::find($id);
		if ($category)
		{
			$subcategories = $category->subcategories;
			foreach ($subcategories as $subcategory)
			{
				/** @var Category $subcategory */
				$result = array_merge(
					$result,
					$this->getCategoryIdsDeeply($subcategory->id)
				);
			}
		}

		return $result;
	}
}
