<?php

namespace App\Models;

use App\Contracts\Iconable;
use App\Contracts\Storeable;
use App\Events\StoreableUpdated;
use App\HasSingleUpload;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Platform extends Model implements Iconable, Storeable
{
    use HasFactory;
	use HasIcon;
	use HasSingleUpload;


	/**
	 * @var array
	 */
	protected $fillable = [
		'name',
		'short_name',
		'icon_path',
	];


	/**
	 * @var array
	 */
	protected $appends = [
		'icon',
		'supported_file_extensions',
	];


	/**
	 * Recebe o relacionamento entre as plataformas e as extensões.
	 *
	 * @return BelongsToMany
	 */
	public function fileExtensions() : BelongsToMany
	{
		return $this->belongsToMany(FileExtension::class);
	}


	/**
	 * Recebe as extensões suportadas por esta plataforma.
	 *
	 * @return Attribute
	 */
	public function supportedFileExtensions() : Attribute
	{
		return Attribute::get(function () : array
		{
			foreach ($this->fileExtensions()->get() as $fileExtension)
			{
				/** @var FileExtension $fileExtension */
				$supportedExtensions[$fileExtension->id] = $fileExtension;
			}

			return $supportedExtensions ?? [];
		});
	}


	/**
	 * Recebe uma lista de extensões suportadas.
	 *
	 * @return array
	 */
	public function fileExtensionsList() : array
	{
		foreach ($this->fileExtensions()->get() as $fileExtension)
		{
			/** @var FileExtension $fileExtension */
			$supportedExtensions[$fileExtension->id] = $fileExtension->extension;
		}
		return $supportedExtensions ?? [];
	}


	/**
	 * Recebe a pasta raiz do conteúdo.
	 *
	 * @return string
	 */
	public function getRootFolder() : string
	{
		return 'platform-icons';
	}


	/**
	 * @return string
	 */
	public function getFileFieldName() : string
	{
		return 'short_name';
	}
}
