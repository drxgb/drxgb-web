<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class DisassociationException extends Exception
{
	/**
	 * Report the exception.
	 */
	public function report() : void
	{
		Log::error('Cannot be disassociated.');
	}


	/**
	 * Get the exception's context information.
	 *
	 * @return array<string, mixed>
	 */
	public function context() : array
	{
		return [];
	}
}
