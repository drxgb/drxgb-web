<?php

namespace App;


trait HasDefaultGetter
{
	/**
	 * Recebe o atributo.
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get(string $name) : mixed
	{
		return property_exists($this, $name)
			? $this->$name
			: null;
	}
}
