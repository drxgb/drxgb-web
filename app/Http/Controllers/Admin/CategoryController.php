<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;

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
        $categories = $this->categories->listWithHierarchy();
		return $this->view('Index', compact('categories'));
    }

    /**
     * Mostra o formulário de criação do novo recurso.
     */
    public function create()
    {
		$categories = $this->categories->listWithHierarchy();
        return $this->view('Form', compact('categories'));
    }

    /**
     * Armazena uma nova instância do recurso.
     */
    public function store(CategoryRequest $request)
    {
        $this->categories->store($request);
		return to_route('admin.categories.index');
    }

    /**
     * Mostra o formulário de edição do recurso específico.
     */
    public function edit(Category $category)
    {
        $categories = $this->categories->listWithHierarchy($category);
		return $this->view('Form', compact('category', 'categories'));
    }

    /**
     * Atualiza o recurso específico no armazenamento.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->categories->update($request, $category);
		return to_route('admin.categories.index');
    }

    /**
     * Remove o recurso específico no armazenamento.
     */
    public function destroy(Category $category)
    {
        $this->categories->destroy($category);
		return redirect()->back();
    }


	/**
	 * @return string
	 */
	protected function viewRootFolder(): string
	{
		return parent::viewRootFolder() . '/Store/Categories';
	}
}
