<?php

namespace App\Http\Controllers\Admin;

use App\Models\Platform;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Mostra o formulário de edição do recurso específico.
     */
    public function edit(Product $product)
    {
        //
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
