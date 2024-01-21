<?php

namespace App\Http\Controllers\Admin;

use App\Models\Platform;
use Illuminate\Http\Request;


/**
 * Ações para manipulação das instâncias de plataforma.
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
class PlatformController extends AdminController
{
    /**
     * Mostra a lista dos recursos.
     */
    public function index()
    {
        $platforms = Platform::paginate(20);
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
     * Mostra o formulário de edição do recurso específico.
     */
    public function edit(Platform $platform)
    {
        //
    }

    /**
     * Atualiza o recurso específico no armazenamento.
     */
    public function update(Request $request, Platform $platform)
    {
        //
    }

    /**
     * Remove o recurso específico no armazenamento.
     */
    public function destroy(Platform $platform)
    {
        //
    }
}
