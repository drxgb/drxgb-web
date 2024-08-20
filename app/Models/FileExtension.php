<?php

namespace App\Models;

use App\Contracts\Iconable;
use App\Contracts\Storeable;
use App\HasSingleUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileExtension extends Model
	implements Iconable, Storeable
{
    use HasFactory, HasIcon, HasSingleUpload;

	protected $fillable = [
		'name',
		'extension',
		'icon_path',
	];

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
}
