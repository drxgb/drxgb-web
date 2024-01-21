<?php

return [
	/*
    |--------------------------------------------------------------------------
    | Estrutura
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

	/*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    |
    | Páginas do painel administrativo.
    |
    */

	'admin'	=> [
		'label'	=> 'Dashboard',
		'url'	=> 'admin.index',
	],
	'file-extensions'	=> [
		'label'	=> 'File extensions',
		'url'	=> 'admin.file-extensions.index',
	],
	'platforms'	=> [
		'label'	=> 'Platforms',
		'url'	=> 'admin.platforms.index',
	],


	/*
    |--------------------------------------------------------------------------
    | Registro de modelos
    |--------------------------------------------------------------------------
    |
    | Representa as páginas de registro de modelos. Normalmente, como
	| costumam ser o caminho final da rota, estes itens não precisam
	| ter os campos 'url' e nem 'literal'.
    |
    */

	'create' => [
		'label'	=> 'Create',
	],
	'edit' => [
		'label'	=> 'Edit',
	],
];
