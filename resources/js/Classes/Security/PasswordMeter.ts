export class PasswordMeter {
	/**
	 * Verifica a força de uma senha.
	 * @param password A senha a ser verificada
	 * @returns O valor da força da senha
	 */
	public check(password?: string): number {
		if (!password)
			return 0;

		const data: any = this.analyzed(password);
		const v = [
			data.numbers > 0,
			data.lowerCases > 0,
			data.upperCases > 0,
			data.symbols > 0,
		];
		const raise = (n: number) => v.filter(x => x === true).length * n;
		let strength = 0;

		strength += data.length;
		strength += data.numbers * raise(2);
		strength += data.lowerCases * raise(4);
		strength += data.upperCases * raise(8);
		strength += data.symbols * raise(16);

		return strength;
	}


	/**
	 * Cria um objeto baseado na senha, organizando o peso.
	 * @param password A senha enviada
	 * @returns Um conjunto de dados com informações de peso da senha
	 */
	private analyzed(password: string): object {
		const result = {
			length: 0,
			lowerCases: 0,
			upperCases: 0,
			numbers: 0,
			symbols: 0,
		};
		const set = new Set<string>(password);
		const match = (regex: RegExp) => {
			let p = '';
			set.forEach(v => p += v);

			const m = p.match(regex);
			return m ? m.length : 0;
		}

		result.length = set.size || 0;
		result.lowerCases = match(/[a-z]/g);
		result.upperCases = match(/[A-Z]/g);
		result.numbers = match(/[0-9]/g);
		result.symbols = match(/[^A-Za-z0-9]/g);

		return result;
	}
}
