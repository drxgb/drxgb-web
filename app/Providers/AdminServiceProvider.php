<?php

namespace App\Providers;

use App\Services\Admin\NavigationLinks;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
	implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
			NavigationLinks::class,
			fn () : NavigationLinks => new NavigationLinks
		);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [ NavigationLinks::class ];
    }
}
