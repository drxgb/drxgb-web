<?php

namespace App\Http\Controllers\Admin;

use App\Models\FileExtension;
use App\Http\Requests\StoreFileExtensionRequest;
use App\Http\Requests\UpdateFileExtensionRequest;
use App\Repositories\FileExtensionRepository;


/**
 * Ações para manipulação das instâncias da extensão de arquivo.
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
class FileExtensionController extends AdminController
{
	public function __construct(
		private FileExtensionRepository $fileExtensions
	)
	{
		parent::__construct();
	}


    /**
     * Mostra a lista dos recursos.
     */
    public function index()
    {
		$extensions = FileExtension::paginate(config('page.items_per_page'));
        return $this->view('Index', compact('extensions'));
    }

    /**
     * Mostra o formulário de criação do novo recurso.
     */
    public function create()
    {
        return $this->view('Form');
    }

    /**
     * Armazena uma nova instância do recurso.
     */
    public function store(StoreFileExtensionRequest $request)
    {
		$this->fileExtensions->store($request);
        return to_route('admin.file-extensions.index');
    }

    /**
     * Mostra o formulário de edição do recurso específico.
     */
    public function edit(FileExtension $fileExtension)
    {
        return $this->view('Form', compact('fileExtension'));
    }

    /**
     * Atualiza o recurso específico no armazenamento.
     */
    public function update(UpdateFileExtensionRequest $request, FileExtension $fileExtension)
    {
		$this->fileExtensions->update($request, $fileExtension);
		return to_route('admin.file-extensions.index');
    }

    /**
     * Remove o recurso específico no armazenamento.
     */
    public function destroy(FileExtension $fileExtension)
    {
		$this->fileExtensions->delete($fileExtension);
		return redirect()->back();
    }


	/**
	 * @return string
	 */
	protected function rootFolder(): string
	{
		return parent::rootFolder() . '/Files/FileExtensions';
	}
}
