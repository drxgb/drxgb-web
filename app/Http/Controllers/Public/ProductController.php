<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Mostra o recurso específico.
     */
    public function show(int $id, string $slug)
    {
		$product = Product::where('id', $id)
			->where('slug', $slug)
			->first();
		$relatedProducts = Product::where('category_id', $product->category_id)
			->where('id', '<>', $product->id)
			->get();

		return $this->view('Product', compact('product', 'relatedProducts'));
    }


	/**
	 * Recebe o nome da pasta base da página.
	 *
	 * @return string
	 */
	protected function rootFolder() : string
	{
		return 'Public/Store';
	}
}
