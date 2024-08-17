export class Cookie
{
	/**
	 * Recupera o valor do cookie de acordo com a chave solicitada.
	 * @param key A chave do cookie
	 * @returns O valor da chave do cookie
	 */
	public static get(key: string) : string
	{
		const name = key + '=';
		const decodedCookie = decodeURIComponent(document.cookie);
		const ca = decodedCookie.split(';');

		for (let c of ca)
		{
			while (c.charAt(0) == ' ')
			{
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0)
			{
				return c.substring(name.length, c.length);
			}
		}
		return '';
	}


	/**
	 * Define um novo valor para o cookie cujo pertence a uma chave solicitada.
	 * @param name A chave do cookie
	 * @param value O novo valor do cookie
	 * @param exdays Quantidade de dias para a expiração do cookie
	 */
	public static set(name: string, value: any, exdays: number = 360) : void
	{
		const d = new Date();
		d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));

		const expires = `expires=${d.toUTCString()}`;
		document.cookie = `${name}=${value}${expires};path=/`;
	}
}
