<?php

namespace App\Providers;

use App\Services\Service;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class CreatorServiceProvider extends ServiceProvider
	implements DeferrableProvider
{
    /**
     * Serviços de registro.
     */
    public function register() : void
    {
		foreach ($this->actions() as $service => $method)
		{
			$this->app->$method($service, fn () : Service => new $service);
		}
    }


	/**
     * Get the services provided by the provider.
     *
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
			\App\Services\FileExtension\CreatorService::class	=> 'singleton',
			\App\Services\Platform\CreatorService::class		=> 'singleton',
			\App\Services\Product\CreatorService::class			=> 'singleton',
			\App\Services\Version\CreatorService::class			=> 'singleton',
			\App\Services\ProductFile\CreatorService::class		=> 'bind',
		];
	}
}
