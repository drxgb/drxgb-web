<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Inertia\Response;

class StoreController extends Controller
{
	public function __construct(
		private ProductRepository $products
	)
	{
		parent::__construct();
	}


	/**
	 * Lista de produtos
	 * @param Request $request
	 * @return Response
	 */
    public function index(Request $request) : Response
	{
		$filters = $this->filters($request);
		$products = $this->products->list($filters);

		if ($request->has('category'))
		{
			$category = Category::find($request->category);
			$subcategories = $category->subcategories;
		}
		else
		{
			$category = null;
			$subcategories = Category::all();
		}

		return $this->view('Index', compact('products', 'category', 'subcategories', 'filters'));
	}


	/**
	 * Recebe os filtros da página.
	 * @param Request $request
	 * @return array
	 */
	private function filters(Request $request) : array
	{
		$filters = [
			'o'	=> $request->has('o') ? intval($request->o) : ProductRepository::MOST_RELEVANT,
			'p'	=> $request->has('p') ? intval($request->p) : 20,
		];

		if ($request->has('category'))
			$filters['category'] = $request->category;

		return $filters;
	}


	/**
	 * Recebe o nome da pasta base da página.
	 * @return string
	 */
	protected function rootFolder(): string
	{
		return 'Public/Store';
	}
}
