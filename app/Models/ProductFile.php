<?php

namespace App\Models;

use App\Contracts\Storeable;
use App\HasFileExtension;
use App\HasSingleUpload;
use App\Utils\Upload;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class ProductFile extends Model
	implements Storeable
{
    use HasFactory;
	use HasSingleUpload;
	use HasFileExtension;


	protected $fillable = [
		'name',
		'file_path',
	];

	protected $appends = [
		'path',
		'supported_platforms',
		'platform_ids',
	];


	/**
	 * Recebe todas as plataformas suportadas pelo arquivo.
	 *
	 * @return BelongsToMany
	 */
	public function platforms() : BelongsToMany
	{
		return $this->belongsToMany(Platform::class);
	}


	/**
	 * Recebe a versão do produto.
	 *
	 * @return BelongsTo
	 */
	public function version() : BelongsTo
	{
		return $this->belongsTo(Version::class);
	}


	/**
	 * Recebe o caminho do arquivo.
	 *
	 * @return Attribute
	 */
	public function path() : Attribute
	{
		return Attribute::get(fn () : string => Storage::url($this->getFullPath()));
	}


	/**
	 * Recebe os IDs das plataformas suportadas pelo arquivo.
	 *
	 * @return Attribute<array<int>>
	 */
	public function platformIds() : Attribute
	{
		return Attribute::get(
			fn () : array => array_map(
				fn (array $platform) : int => $platform['id'],
				$this->platforms()->get()->toArray()
			)
		);
	}


	/**
	 * Recebe as plataformas suportadas pelo arquivo.
	 *
	 * @return Attribute<array<Platform>>
	 */
	public function supportedPlatforms() : Attribute
	{
		return Attribute::get(fn () : array => $this->platforms()->get()->toArray());
	}


	/**
	 * Recebe a pasta raiz do conteúdo.
	 *
	 * @return string
	 */
	public function getRootFolder() : string
	{
		return Upload::makePathById('product-files', $this->id);
	}


	/**
	 * @return string
	 */
	public function getFileFieldName() : string
	{
		return 'name';
	}


	/**
	 * @return string
	 */
	public function getPathFieldName() : string
	{
		return 'file_path';
	}
}
