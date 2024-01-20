type DataColumnCallback = ((obj: any) => any);

export default class DataColumn {
	/** O texto de exibição da coluna */
	private _label: string;

	/** A chave ou callback que representa a propriedade da coluna */
	private _key: string | DataColumnCallback;

	/** A classe de estilo da coluna */
	private _classStyle: string;


	constructor(label: string, key: string | DataColumnCallback, classStyle: string = '') {
		this._label = label;
		this._key = key;
		this._classStyle = classStyle;
	}


	get label(): string {
		return this._label;
	}


	get classStyle(): string {
		return this._classStyle;
	}


	/**
	 * Recebe o valor da coluna.
	 * @param obj O objeto.
	 * @returns O valor da coluna.
	 */
	getValue(obj: any): any {
		if ((typeof this._key) === 'string') {
			return obj[this._key as string];
		}

		const value: DataColumnCallback = this._key as DataColumnCallback;
		return value(obj);
	}
}
