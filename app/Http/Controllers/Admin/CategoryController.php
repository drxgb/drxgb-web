<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends AdminController
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
        $categories = Category::paginate(config('page.items_per_page', 20));
		return $this->view('Index', compact('categories'));
    }

    /**
     * Mostra o formulário de criação do novo recurso.
     */
    public function create()
    {
        //
    }

    /**
     * Armazena uma nova instância do recurso.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Mostra o recurso específico.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Mostra o formulário de edição do recurso específico.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Atualiza o recurso específico no armazenamento.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove o recurso específico no armazenamento.
     */
    public function destroy(Category $category)
    {
        //
    }


	/**
	 * @return string
	 */
	protected function rootFolder(): string
	{
		return parent::rootFolder() . '/Store/Categories';
	}
}
