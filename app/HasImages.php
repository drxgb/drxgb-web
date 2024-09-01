<?php

namespace App;


trait HasImages
{
	/**
	 * @return string
	 */
	public function getPathFieldName() : string
	{
		return 'id';
	}


	/**
	 * @return string
	 */
	public function getFileExtension() : string
	{
		return 'gif';
	}
}
