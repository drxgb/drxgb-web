<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;


trait CreatesAdminUser
{
	/**
	 * O usuário administrador de teste.
	 *
	 * @var User
	 */
	private $user;


	/**
	 * Cria o usuário administrador.
	 *
	 * @return void
	 */
	protected function createAdminUser() : void
	{
		$this->user = User::factory()->admin()->create();
	}


	/**
	 * Remove o ousuário administrador.
	 *
	 * @return void
	 */
	protected function deleteAdminUser() : void
	{
		$role = $this->user->Role;

		$this->user->delete();
		$role->delete();
	}
}
