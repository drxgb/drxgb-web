<?php

return [
	/*
    |--------------------------------------------------------------------------
    | Admin Inbox
    |--------------------------------------------------------------------------
    |
    | Define o link do email do administrador.
    |
    */

	'inbox_url'	=> env('EMAIL_INBOX_URL'),


	/*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    |
    | Todos os itens de navegação do painel administrativo ficam
	| neste grupo.
    |
    */

	'nav_links' => [
			// Dashboard
			[
				'icon'	=> 'gauge',
				'title'	=> 'Dashboard',
				'href'	=> 'admin.index',
			],
			// Arquivos
			[
				'icon'	=> 'file',
				'title'	=> 'Files',
				'items'	=> [
					[
						'title'	=> 'File extensions',
						'href'	=> 'admin.file-extensions.index',
					],
					[
						'title'	=> 'Platforms',
						'href'	=> 'admin.platforms.index',
					],
				],
			],
			// Modelo
			/* [
				'icon'	=> 'user',						// Ícone do Font Awesome
				'title'	=> 'Item',						// Nome do item
				'href'	=> 'admin.index',				// Nome da rota que gera o link deste item ou o próprio link caso este array possua 'literal'
				'literal'	=> true,					// Se for falso, 'href' será convertido em rota
				'items'	=> [],							// Um conjunto de itens desta seção. A estrutura do array é a mesma desta.
			], */
		],
];
