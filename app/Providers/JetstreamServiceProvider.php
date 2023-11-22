<?php

namespace App\Providers;

use Inertia\Inertia;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;
use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

		Fortify::loginView(function () {
			return Inertia::render('Auth/Login', [
				'canResetPassword' 	=> Route::has('password.request'),
				'canUseSocialMedia'	=> true,
				'canRegister'		=> Route::has('register'),
				'status' 			=> session('status'),
			]);
		});

        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
