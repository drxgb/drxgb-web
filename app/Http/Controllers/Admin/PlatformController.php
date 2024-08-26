<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePlatformRequest;
use App\Http\Requests\UpdatePlatformRequest;
use App\Models\Platform;
use App\Repositories\PlatformRepository;
use App\Services\Platform\CreatorService;
use App\Services\Platform\DeleterService;
use App\Services\Platform\EditorService;

/**
 * Ações para manipulação das instâncias de plataforma.
 *
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
class PlatformController extends AdminController
{
	public function __construct(
		private PlatformRepository $platforms
	)
	{
		parent::__construct();
	}


    /**
     * Mostra a lista dos recursos.
     */
    public function index()
    {
        $platforms = Platform::paginate(config('page.items_per_page'));
		return $this->view('Index', compact('platforms'));
    }


    /**
     * Mostra o formulário de criação do novo recurso.
     */
    public function create()
    {
		$extensions = $this->platforms->extensions('extension');
        return $this->view('Form', compact('extensions'));
    }


    /**
     * Armazena uma nova instância do recurso.
     */
    public function store(StorePlatformRequest $request)
    {
		$attributes = $request->safe()->only([ 'name', 'short_name' ]);
		$fileExtensions = $request->file_extensions;
		$icon = $request->icon;

		/** @var CreatorService */
		$creator = app(CreatorService::class);
		$creator->fill($attributes)
			->attach($fileExtensions)
			->setUploadedFile($icon)
			->save();

        return to_route('admin.platforms.index');
    }


    /**
     * Mostra o formulário de edição do recurso específico.
     */
    public function edit(Platform $platform)
    {
		$extensions = $this->platforms->extensions('extension');
        return $this->view('Form', compact('platform', 'extensions'));
    }


    /**
     * Atualiza o recurso específico no armazenamento.
     */
    public function update(UpdatePlatformRequest $request, Platform $platform)
    {
		$attributes = $request->safe()->only([ 'name', 'short_name' ]);
		$fileExtensions = $request->file_extensions;
		$icon = $request->icon;

		/** @var EditorService */
		$editor = app(EditorService::class, compact('platform'));
		$editor->fill($attributes)
			->sync($fileExtensions)
			->setUploadedFile($icon)
			->save();

		return to_route('admin.platforms.index');
    }


    /**
     * Remove o recurso específico no armazenamento.
     */
    public function destroy(Platform $platform)
    {
		$deleter = app(DeleterService::class, compact('platform'));
		$deleter->delete();

		return redirect()->back();
    }


	/**
	 * @return string
	 */
	protected function viewRootFolder(): string
	{
		return parent::viewRootFolder() . '/Files/Platforms';
	}
}
