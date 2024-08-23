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
		foreach ($this->provides() as $class)
		{
			$this->app->singleton(
				$class,
				fn (Model $model) : Service => new $class($model)
			);
		}
    }


	/**
	 * @return array
	 */
	public function provides() : array
	{
		return [
			\App\Services\FileExtension\DeleterService::class,
			\App\Services\Platform\DeleterService::class,
		];
	}
}
