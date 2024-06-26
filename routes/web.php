<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FileExtensionController;
use App\Http\Controllers\Admin\PlatformController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\VersionController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Public\LanguageController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//* Página principal
Route::get('/', HomeController::class)->name('home');


//* Autenticação com rede social
Route::name('oauth.')->prefix('oauth')->controller(OAuthController::class)->group(function ()
{
	Route::get('/{provider}', 'redirect')->name('redirect');
	Route::get('/{provider}/callback', 'callback')->name('callback');
});


//* Área de usuário autenticado
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function ()
{
	//* Painel Administrativo
	Route::middleware('admin')->name('admin.')->prefix('admin')->group(function ()
	{
		Route::get('/', DashboardController::class)->name('index');
		Route::resource('file-extensions', FileExtensionController::class)->except('show');
		Route::resource('platforms', PlatformController::class)->except('show');
		Route::resource('categories', CategoryController::class)->except('show');
		Route::resource('products', AdminProductController::class)->except('show');

		Route::prefix('versions')->name('versions.')->group(function ()
		{
			Route::post('/save', [ VersionController::class, 'save' ])->name('save');
		});
	});
});


//* Idiomas
Route::name('languages.')->controller(LanguageController::class)->group(function ()
{
	Route::post('/languages', 'change')->name('change');
});


//* Loja
Route::name('store.')->prefix('store')->controller(StoreController::class)->group(function ()
{
	Route::get('/', 'index')->name('index');
});


//* Produto
Route::name('product.')->prefix('product')->controller(ProductController::class)->group(function ()
{
	Route::get('/{id}/{slug}', 'show')->name('show');
});
