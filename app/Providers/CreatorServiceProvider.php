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
        $this->app->singleton(\App\Services\FileExtension\CreatorService::class,
			fn () : Service => new \App\Services\FileExtension\CreatorService
		);
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
		];
	}
}
