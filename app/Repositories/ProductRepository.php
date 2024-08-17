<?php

namespace App\Repositories;

use App\Utils\Upload;
use App\Models\Product;
use App\Models\Category;
use App\Models\Version;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
	 * Cria um novo produto.
	 *
	 * @param Request $request
	 * @return Product
	 */
	public function store(Request $request): Product
	{
		$product = Product::create([
			'title'			=> $request->title,
			'slug'			=> $request->slug,
			'page'			=> $request->page,
			'description'	=> $request->description,
			'price'			=> $request->price,
			'active'		=> $request->active,
			'cover_index'	=> $request->cover_index,
		]);

		if ($request->category_id)
		{
			$category = Category::find($request->category_id);
			$category->products()->save($product);
		}
		if ($request->hasFile('images'))
			$this->uploadImages($product, $request->file('images'));

		$this->saveVersions($request, $product);
		return $product;
	}


	/**
	 * Modifica um produto existente.
	 *
	 * @param Request $request
	 * @param Product $product
	 * @return void
	 */
	public function update(Request $request, Product $product): void
	{
		$product->update([
			'title'			=> $request->title,
			'slug'			=> $request->slug,
			'page'			=> $request->page,
			'description'	=> $request->description,
			'price'			=> $request->price,
			'active'		=> $request->active,
			'cover_index'	=> $request->cover_index,
		]);

		if ($request->category_id)
		{
			$category = Category::find($request->category_id);
			$category->products()->save($product);
		}
		else
			$product->category()->disassociate();

		if ($request->hasFile('images'))
			$this->uploadImages($product, $request->file('images'));

		$this->saveVersions($request, $product);
		$this->deleteVersions($request->deleted_versions);
		$product->save();
	}


	/**
	 * Apaga o produto.
	 *
	 * @param Product $product
	 * @return void
	 */
	public function delete(Product $product) : void
	{
		$deletedIds = array_map(
			fn (array $version) : int => $version['id'],
			$product->versions()->get()->toArray()
		);
		$this->deleteVersions($deletedIds);
		$this->deleteImages($product);
		$product->delete();
	}


	/**
	 * Salva as versões deste produto.
	 *
	 * @param Request $request
	 * @param Product $product
	 * @return void
	 */
	public function saveVersions(Request $request, Product $product) : void
	{
		if ($request->versions)
		{
			$repository = new VersionRepository;
			$savedVersions = [];

			foreach ($request->versions as $versionData)
			{
				if (isset($versionData['id']))
				{
					$version = Version::find($versionData['id']);
					$repository->update($versionData, $version);
				}
				else
					$version = $repository->store($versionData, $product);
				$savedVersions[] = $version;
			}

			$product->versions()->saveMany($savedVersions);
		}
	}


	/**
	 * Apaga as versões que não estão mais relacionadas.
	 *
	 * @param ?array $ids
	 * @return void
	 */
	public function deleteVersions(?array $ids) : void
	{
		if ($ids)
		{
			$repository = new VersionRepository;
			foreach ($ids as $id)
			{
				$version = Version::find($id);
				if ($version)
					$repository->delete($version);
			}
		}
	}


	/**
	 * Faz o upload da imagens do produto.
	 *
	 * @param Product $product
	 * @param array<\Illuminate\Http\UploadedFile> $images
	 * @return void
	 */
	private function uploadImages(Product $product, array $images) : void
	{
		$path = Upload::makePath('product-images', $product->id);
		Storage::disk('public')->deleteDirectory($path);

		foreach ($images as $i => $image)
		{
			$ext = $image->getClientOriginalExtension();
			$filename = "$i.$ext";
			$image->storePubliclyAs($path, $filename, 'public');
		}
	}


	/**
	 * Apaga as imagens do produto.
	 *
	 * @param Product $product
	 * @return void
	 */
	private function deleteImages(Product $product) : void
	{
		$path = Upload::makePath('product-images', $product->id);
		Storage::disk('public')->deleteDirectory($path);
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
