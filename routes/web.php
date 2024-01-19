<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FileExtensionController;
use App\Http\Controllers\Public\LanguageController;
use App\Http\Controllers\Public\HomeController;
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


//* Área de usuário autenticado
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
	// TODO: Adicionar controladores da área autenticada
});


//* Idiomas
Route::name('languages.')->controller(LanguageController::class)-> group(function () {
	Route::post('/languages', 'change')->name('change');
});


//* Painel Administrativo
Route::middleware([ 'admin', 'verified' ])->name('admin.')->prefix('admin')->group(function () {
	Route::get('/', DashboardController::class)->name('index');
	Route::resource('file-extensions', FileExtensionController::class);
});
