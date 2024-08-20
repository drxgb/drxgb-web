<?php

namespace App\Providers;

use App\Services\Service;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class EditorServiceProvider extends ServiceProvider
	implements DeferrableProvider
{
    /**
     * Serviços de registro.
     */
    public function register() : void
    {
        $this->app->singleton(\App\Services\FileExtension\EditorService::class,
			fn (\App\Models\FileExtension $fileExtension) : Service =>
				new \App\Services\FileExtension\EditorService($fileExtension)
		);
    }


	/**
	 * @return array
	 */
	public function provides() : array
	{
		return [
			\App\Services\FileExtension\EditorService::class,
		];
	}
}
