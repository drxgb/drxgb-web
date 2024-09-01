<?php

namespace App\Models;

use App\HasIcon;
use App\HasSingleUpload;
use App\Contracts\Iconable;
use App\Contracts\Storeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class FileExtension extends Model implements Iconable, Storeable
{
    use HasFactory, HasIcon, HasSingleUpload;

	/**
	 * @var array
	 */
	protected $fillable = [
		'name',
		'extension',
		'icon_path',
	];

	/**
	 * @var array
	 */
	protected $appends = [
		'icon',
	];


	/**
	 * Recebe a pasta raiz do conteúdo.
	 *
	 * @return string
	 */
	public function getRootFolder() : string
	{
		return 'extension-icon';
	}


	/**
	 * @return string
	 */
	public function getFileFieldName() : string
	{
		return 'extension';
	}
}
