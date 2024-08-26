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
		foreach ($this->provides() as $providerClass)
		{
			$this->app->singleton($providerClass, fn () : Service => new $providerClass);
		}
    }


	/**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() : array
	{
		return [
			\App\Services\FileExtension\CreatorService::class,
			\App\Services\Platform\CreatorService::class,
			\App\Services\Product\CreatorService::class,
			\App\Services\ProductFile\CreatorService::class,
		];
	}
}
