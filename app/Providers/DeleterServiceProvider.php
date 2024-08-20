<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;


class DeleterServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Serviços de registro.
     */
    public function register() : void
    {
        $this->app->singleton(\App\Services\FileExtension\DeleterService::class,
			fn (\App\Models\FileExtension $fileExtension) =>
				new \App\Services\FileExtension\DeleterService($fileExtension)
		);
    }


	/**
	 * @return array
	 */
	public function provides() : array
	{
		return [
			\App\Services\FileExtension\DeleterService::class,
		];
	}
}
