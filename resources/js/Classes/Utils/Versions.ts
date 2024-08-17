/**
 * Classe utilitária para definir padrões de versionamento.
 */
export default class Versions
{
	/**
	 * Recebe o nome da versão em forma de texto.
	 * @param version Número da versão
	 * @returns A versão em formato de texto.
	 */
	public static toString(version? : number) : string
	{
		let major: number,
			minor: number,
			patch: number,
			type: string,
			num: number;
		let typeNum: number,
			result: string;

		if (!version)
			version = 0;

		num = Math.floor(version) % 10;
		typeNum = Math.floor(version / 10) % 10;
		patch = Math.floor(version / 100) % 100;
		minor = Math.floor(version / 10000) % 100;
		major = Math.floor(version / 1000000);
		type = Versions.getType(typeNum);

		result = `${major}.${minor}.${patch}`;
		if (type)
		{
			result += ` ${type}`;

			if (num > 0)
			{
				result += ` ${num}`;
			}
		}

		return result;
	}


	/**
	 * Recebe o nome do tipo da versão.
	 * @param type Tipo da versão
	 * @returns O nome do tipo da versão
	 */
	private static getType(type : number) : string|null
	{
		const types: object = {
			1: 'Alpha',
			3: 'Beta',
			5: 'Release Candidate',
			7: 'Stable',
		};

		return types[type];
	}
};
