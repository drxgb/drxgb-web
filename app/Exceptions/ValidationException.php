<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    public function __construct(string $message, array $errors = [])
	{
		$errorsList = implode('', array_map(fn (string $e) : string => "<li>$e</li>", $errors));
		parent::__construct("$message<br /><ul>$errorsList</ul>");
	}
}
