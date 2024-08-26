<?php

namespace App\Http\Controllers\Admin;

use App\Models\FileExtension;
use App\Http\Requests\StoreFileExtensionRequest;
use App\Http\Requests\UpdateFileExtensionRequest;
use App\Services\FileExtension\CreatorService;
use App\Services\FileExtension\DeleterService;
use App\Services\FileExtension\EditorService;

/**
 * Ações para manipulação das instâncias da extensão de arquivo.
 *
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
class FileExtensionController extends AdminController
{
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
		$attributes = $request->safe()->only([ 'name', 'extension' ]);
		$upload = $request->file('icon');

		/** @var CreatorService */
		$creator = app(CreatorService::class);
		$creator->fill($attributes)->setUploadedFile($upload)->save();

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
		$attributes = $request->safe()->only([ 'name', 'extension' ]);
		$upload = $request->file('icon');

		/** @var EditorService */
		$editor = app(EditorService::class, compact('fileExtension'));
		$editor->fill($attributes)->setUploadedFile($upload)->save();

		return to_route('admin.file-extensions.index');
    }

    /**
     * Remove o recurso específico no armazenamento.
     */
    public function destroy(FileExtension $fileExtension)
    {
		/** @var DeleterService */
		$deleter = app(DeleterService::class, compact('fileExtension'));
		$deleter->delete();

		return redirect()->back();
    }


	/**
	 * @return string
	 */
	protected function viewRootFolder(): string
	{
		return parent::viewRootFolder() . '/Files/FileExtensions';
	}
}
