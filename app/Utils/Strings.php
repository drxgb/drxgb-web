<?php

namespace App\Utils;


/**
 * Contém funções utilitárias para strings
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
abstract class Strings
{
	/**
	 * Transforma um texto em nome com padrão do nome de usuário.
	 * @param string $input
	 * @return string
	 */
	public static function makeUserName(string $input) : string
	{
		$name = str_replace('-', '_', $input);
		$name = preg_replace('/[\W]+/i', '', $name);
		return strtolower($name);
	}


	/**
	 * Transforma um nome de email em um nome de usuário.
	 * @param string $email
	 * @return string
	 */
	public static function makeUserNameFromEmail(string $email) : string
	{
		list($name) = explode('@', $email, 2);
		return self::makeUserName($name);
	}
}
