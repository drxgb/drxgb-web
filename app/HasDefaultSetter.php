<?php

namespace App;


trait HasDefaultSetter
{
	/**
	 * Define o valor do atributo.
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return void
	 */
	public function __set(string $name, mixed $value) : void
	{
		if (property_exists($this, $name))
		{
			$this->$name = $value;
		}
	}
}
