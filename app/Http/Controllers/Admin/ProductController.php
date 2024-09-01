<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Platform;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Services\Product\CreatorService;
use App\Services\Product\DeleterService;
use App\Services\Product\EditorService;

class ProductController extends AdminController
{
	public function __construct(
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
		$attributes = $request->safe()->only([
			'title', 'slug', 'page', 'description', 'price', 'active', 'cover_index'
		]);
		$categoryId = $request->category_id;
		$versions = $request->versions;
		$images = $request->images;

		$product = app(CreatorService::class)
			->fill($attributes)
			->assign($versions)
			->associate($categoryId)
			->setUploadedFiles($images)
			->shouldRefresh()
			->save();

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
		$attributes = $request->safe()->only([
			'title', 'slug', 'page', 'description', 'price', 'active', 'cover_index'
		]);
		$categoryId = $request->category_id;
		$versions = $request->versions;
		$images = $request->images;

		app(EditorService::class, compact('product'))
			->fill($attributes)
			->assign($versions)
			->associate($categoryId)
			->setUploadedFiles($images)
			->shouldRefresh()
			->save();

		return to_route('admin.products.index')
			->with('message', __('messages.updated', [ 'name' => $product->title ]));
    }


    /**
     * Remove o recurso específico no armazenamento.
     */
    public function destroy(Product $product)
    {
		app(DeleterService::class, compact('product'))->delete();

		return redirect()->back()
			->with('message', __('messages.deleted', [ 'name' => $product->title ]));
    }


	/**
	 * @return string
	 */
	protected function viewRootFolder(): string
	{
		return parent::viewRootFolder() . '/Store/Products';
	}
}
