<?php

namespace App\Repositories;

use App\Utils\Upload;
use App\Models\Product;
use App\Models\Category;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
			$this->uploadImages($product, $request->file('images'));

		$this->saveVersions($request, $product);
		return $product;
	}


	/**
	 * Modifica um produto existente.
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
	 * @param Product $product
	 * @return void
	 */
	private function deleteImages(Product $product) : void
	{
		$path = Upload::makePath('product-images', $product->id);
		Storage::disk('public')->deleteDirectory($path);
	}
}
