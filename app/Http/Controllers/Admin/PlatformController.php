<?php

namespace App\Http\Controllers\Admin;

use App\Models\Platform;
use App\Repositories\PlatformRepository;
use App\Http\Requests\StorePlatformRequest;
use App\Http\Requests\UpdatePlatformRequest;


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
		$this->platforms->store($request);
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
        $this->platforms->update($request, $platform);
		return to_route('admin.platforms.index');
    }

    /**
     * Remove o recurso específico no armazenamento.
     */
    public function destroy(Platform $platform)
    {
        $this->platforms->delete($platform);
		return redirect()->back();
    }


	/**
	 * @return string
	 */
	protected function rootFolder(): string
	{
		return parent::rootFolder() . '/Files/Platforms';
	}
}
