const SYMBOL_PATTERN: RegExp = /[ _+~<>,.;/?|!@#$%¨&*\(\)\\]/gi;


/**
 * Classe com funções utilitárias para campos de formulário.
 */
export default class Forms {
	/**
	 * Realiza o filtro de entrada permitindo somente números.
	 * @param ev Evento tratado
	 * @returns Se o valor deve ser atualizado ou não.
	 */
	public static filterOnlyNumbers(ev: any): boolean {
		if (!ev.key.match(/\d*/i)[0]) {
			ev.preventDefault();
			return false;
		}
		return true;
	}


	/**
	 * Transforma o texto em kebab-case.
	 * @param text O texto a ser transformado.
	 * @param constant Se for uma constante, deve-se converter para maiúsculo.
	 * @returns O texto no padrão kebab-case.
	 */
	public static toKebabCase(text: string, constant: boolean = false): string {
		const result: string = Forms.cleanString(text).replaceAll(SYMBOL_PATTERN, '-');

		if (constant) {
			return result.toUpperCase();
		}
		return result.toLowerCase();
	}


	/**
	 * Retira qualquer espécie de espaçamento de um texto.
	 * @param text O texto a ser tratado.
	 * @returns Um texto sem espaçamento.
	 */
	public static wipeWhitespaces(text: string): string {
		return text.replaceAll(/\s/gi, '');
	}


	/**
	 * Limpa a string removendo acentos das vogais e outros símbolos.
	 * @param text A string a ser tratada
	 * @returns A string limpa.
	 */
	private static cleanString(text: string): string {
		return text
			.replaceAll(/[áàãâäª]/gi, 'a')
			.replaceAll(/[éèêë]/gi, 'e')
			.replaceAll(/[íìîï]/gi, 'i')
			.replaceAll(/[óòõôöº°]/gi, 'o')
			.replaceAll(/[úùûü]/gi, 'u')
			.replaceAll(/[ç]/gi, 'c');
	}
};
