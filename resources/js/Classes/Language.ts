export class Language
{
	private _id : Number;
	private _name : string;
	private _locale : string;
	private _countryFlag : string;


	public constructor(id : any, name : string, locale : string, countryFlag : string)
	{
		this._id = Number(id);
		this._name = name;
		this._locale = locale;
		this._countryFlag = countryFlag;
	}


	get id() : Number
	{
		return this._id;
	}
	get name() : string
	{
		return this._name;
	}

	get locale() : string
	{
		return this._locale;
	}

	get countryFlag() : string
	{
		return this._countryFlag;
	}
}
