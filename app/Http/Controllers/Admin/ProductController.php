<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Platform;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
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
    public function store(ProductRequest $request)
    {
		$this->products->store($request);
        return to_route('admin.products.index')
			->with('message', 'Product created successfully!');
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
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove o recurso específico no armazenamento.
     */
    public function destroy(Product $product)
    {
        //
    }


	/**
	 * @return string
	 */
	protected function rootFolder(): string
	{
		return parent::rootFolder() . '/Store/Products';
	}
}
