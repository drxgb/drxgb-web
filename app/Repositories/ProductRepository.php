<?php

namespace App\Repositories;

use App\Utils\Upload;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductRepository
{
	/**
	 * Cria um novo produto.
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
		{
			$this->uploadImages($product, $request->file('images'));
		}

		$this->saveVersions($request, $product);
		return $product;
	}


	public function saveVersions(Request $request, Product $product) : void
	{
		if ($request->versions)
		{
			$repository = new VersionRepository;
			foreach ($request->versions as $versionData)
			{
				if (isset($versionData['id']))
				{

				}
				else
					$repository->store($versionData, $product);
			}
		}
	}


	/**
	 * Faz o upload da imagens do produto.
	 * @param Product $product
	 * @param array<\Illuminate\Http\UploadedFile> $images
	 * @return void
	 */
	public function uploadImages(Product $product, array $images) : void
	{
		foreach ($images as $i => $image)
		{
			$image->storePubliclyAs(
				Upload::makePath('product-images', $product->id),
				$i,
				'public'
			);
		}
	}
}
