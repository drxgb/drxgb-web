export class PasswordMeter {
	/**
	 * Verifica a força de uma senha.
	 * @param password A senha a ser verificada
	 * @returns Um objeto contendo a força da senha e a chave para mensagens
	 */
	public check(password: string): number {
		let strength = 0;
		let last = null;

		for (const p of password) {
			strength += this.compute(p, last);
			last = p;
		}

		return strength + password.length;
	}


	private compute(current: string, last?: string): number {
		const c = this.getStrength(current);
		const l = last !== null ? this.getStrength(last) : 0;

		return Math.abs(c - l);
	}



	private getStrength(current: string): number {
		const code = current.charCodeAt(0);

		if (current.match(/[0-9]/))
			return (code - 48 - 1) * 1;
		if (current.match(/[a-z]/))
			return (code - 97 - 1) * 2;
		if (current.match(/[A-Z]/))
			return (code - 65 - 1) * 4;
		return (code - 33 - 1) * 8;
	}
}
