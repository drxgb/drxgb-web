<?php

namespace App\Providers;

use App\Services\Service;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;


class DeleterServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Serviços de registro.
     */
    public function register() : void
    {
		foreach ($this->actions() as $service => $method)
		{
			$this->app->$method($service, fn (Model $model) : Service => new $service($model));
		}
    }


	/**
	 * @return array
	 */
	public function provides() : array
	{
		return array_keys($this->actions());
	}


	/**
	 * Recebe as ações que devem ser realizadas para cada serviço.
	 *
	 * @return array
	 */
	private function actions() : array
	{
		return [
			\App\Services\FileExtension\DeleterService::class	=> 'singleton',
			\App\Services\Platform\DeleterService::class			=> 'singleton',
			//\App\Services\Product\DeleterService::class			=> 'singleton',
			\App\Services\ProductFile\DeleterService::class		=> 'bind',
		];
	}
}
