export class ThemeHandler
{
	private static instance : ThemeHandler;


	/**
	 * Recebe a instância única do manipulador de temas
	 * @returns A instância de ThemeHandler
	 */
	public static getInstance() : ThemeHandler
	{
		if (!ThemeHandler.instance)
		{
			ThemeHandler.instance = new ThemeHandler;
		}

		return ThemeHandler.instance;
	}


	/**
	 * Recupera o tema atual
	 * @returns O tema atual
	 */
	public getTheme(): string
	{
		return localStorage.getItem('xgb_theme') || 'light';
	}


	/**
	 * Altera o tema da página
	 * @param theme O nome do tema a ser alterado
	 */
	public setTheme(theme: string) : void
	{
		if (theme !== 'light' && theme !== 'dark')
			throw new Error(`${theme} is not a valid theme.`);

		localStorage.setItem('xgb_theme', theme);
		this.load();
	}


	/**
	 * Carrega o tema atual na página
	 */
	public load() : void
	{
		const theme = this.getTheme();
		const html = document.querySelector('html');

		if (theme === 'dark')
			html.classList.add('dark');
		else
			html.classList.remove('dark');
	}
}
