<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CategoryRepository
{
	/**
	 * Lista as categorias em forma de hieraquia.
	 *
	 * @param Category|array $excluded
	 * @return Collection<string, array>
	 */
	public function listWithHierarchy(Category|array $excluded = []) : Collection
	{
		$categories = new Collection();
		$roots = Category::where('parent_id', null)->get();

		if (!is_array($excluded))
			$excluded = [ $excluded ];

		$excludedIds = array_map(
			fn (Category $category) : int => intval($category->id),
			$excluded
		);
		$this->addChildren($categories, $roots, $excludedIds);

		return $categories;
	}


	/**
	 * Cria uma nova categoria.
	 *
	 * @param Request $request
	 * @return Category
	 */
	public function store(Request $request) : Category
	{
		$category = Category::create([
			'name' => $request->name,
		]);

		if ($request->parent_id)
		{
			$parent = Category::find($request->parent_id);
			$parent->subcategories()->save($category);
		}

		return $category;
	}


	/**
	 * Atualiza a categoria.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Category $category
	 * @return void
	 */
	public function update(Request $request, Category $category) : void
	{
		$category->update([
			'name' => $request->name,
		]);
		if ($request->parent_id)
		{
			$parent = Category::find($request->parent_id);
			$category->parent()->associate($parent);
		}
		else
		{
			$category->parent()->disassociate();
		}
		$category->save();
	}


	/**
	 * Deleta uma categoria.
	 *
	 * @param Category $category
	 * @return void
	 */
	public function destroy(Category $category) : void
	{
		$category->delete();
	}


	/**
	 * Adiciona as subcategorias em sequência.
	 *
	 * @param Collection $collection
	 * @param mixed $group
	 * @param array<int> $excludedIds
	 * @param int $depth
	 * @return void
	 */
	private function addChildren(Collection $collection, mixed $group, array $excludedIds, int $depth = 0)
	{
		foreach ($group as $item)
		{
			if (!is_array($item))
				$item = $item->toArray();
			$item['depth'] = $depth;

			if (!in_array($item['id'], $excludedIds))
			{
				$collection->add($item);
				if (count($item['children']) > 0)
					$this->addChildren($collection, $item['children'], $excludedIds, $depth + 1);
			}
		}
	}
}
