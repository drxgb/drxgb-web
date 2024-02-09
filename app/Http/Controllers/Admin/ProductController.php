<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Platform;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;

class ProductController extends AdminController
{
	public function __construct(
		private ProductRepository $products,
		private CategoryRepository $categories
	)
	{
		parent::__construct();
	}


    /**
     * Mostra a lista dos recursos.
     */
    public function index()
    {
        $products = Product::paginate(config('page.items_per_page', 20));
		return $this->view('Index', compact('products'));
    }

    /**
     * Mostra o formulário de criação do novo recurso.
     */
    public function create()
    {
		$categories = $this->categories->listWithHierarchy();
		$platforms = fn () => Platform::all();
        return $this->view('Form', compact('categories', 'platforms'));
    }

    /**
     * Armazena uma nova instância do recurso.
     */
    public function store(StoreProductRequest $request)
    {
		$product = $this->products->store($request);
        return to_route('admin.products.index')
			->with('message', __('messages.created', [ 'name' => $product->title ]));
    }

    /**
     * Mostra o formulário de edição do recurso específico.
     */
    public function edit(Product $product)
    {
        $categories = $this->categories->listWithHierarchy();
		$platforms = fn () => Platform::all();
        return $this->view('Form', compact('product', 'categories', 'platforms'));
    }

    /**
     * Atualiza o recurso específico no armazenamento.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->products->update($request, $product);
		return to_route('admin.products.index')
			->with('message', __('messages.updated', [ 'name' => $product->title ]));
    }

    /**
     * Remove o recurso específico no armazenamento.
     */
    public function destroy(Product $product)
    {
        $this->products->delete($product);
		return redirect()->back()
			->with('message', __('messages.deleted', [ 'name' => $product->title ]));
    }


	/**
	 * @return string
	 */
	protected function rootFolder(): string
	{
		return parent::rootFolder() . '/Store/Products';
	}
}
