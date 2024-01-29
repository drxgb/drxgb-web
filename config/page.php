<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Lista de itens
	|--------------------------------------------------------------------------
	|
	| Configurações para a listagem de itens.
	|
	*/

	'items_per_page' => 20,


	/*
	|--------------------------------------------------------------------------
	| Migalhas de Pão
	|--------------------------------------------------------------------------
	|
	| label		-> 	Nome que aparecerá na lista
	| url		-> 	Link do item
	| literal	-> 	Se este campo existir e for verdadeiro, o campo 'url'
	|				não será convertido para rota
	|--------------------------------------------------------------------------
	|
	| 'path_item'	=> [
	|	'label'		=> '',
	|	'url'		=> '',
	| 	'literal'	=> true,
	| ],
	|
	*/
	'breadcrumbs' => [

		//* Páginas do painel administrativo.
		'categories' => [
			'label'	=> 'Categories',
			'url'	=> 'admin.categories.index',
		],
		'file-extensions'	=> [
			'label'	=> 'File extensions',
			'url'	=> 'admin.file-extensions.index',
		],
		'platforms'	=> [
			'label'	=> 'Platforms',
			'url'	=> 'admin.platforms.index',
		],
		'products'	=> [
			'label'	=> 'Products',
			'url'	=> 'admin.products.index',
		],


		//* Abas do painel administrativo
		'admin'	=> [
			'label'	=> 'Dashboard',
			'url'	=> 'admin.index',
		],


		//* Registro de modelos.
		// Estes itens não precisam ter os campos 'url' e nem 'literal'.
		'create' => [
			'label'	=> 'Create',
		],
		'edit' => [
			'label'	=> 'Edit',
		],
	],
];
