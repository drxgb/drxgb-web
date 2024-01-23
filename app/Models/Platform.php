<?php

namespace App\Models;

use App\Contracts\Iconable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends Model
	implements Iconable
{
    use HasFactory, HasIcon;

	protected $fillable = [
		'name',
		'short_name',
		'icon_path',
	];

	protected $appends = [
		'icon',
		'file_extensions',
	];


	/**
	 * Recebe as extensões suportadas por esta plataforma.
	 * @return Attribute
	 */
	public function fileExtensions(): Attribute
	{
		return Attribute::get(fn () : BelongsToMany =>
			$this->belongsToMany(FileExtension::class));
	}


	/**
	 * Recebe a pasta raiz do conteúdo.
	 * @return string
	 */
	public function getRootFolder() : string
	{
		return 'platform-icons';
	}


	/**
	 * Recebe o nome do arquivo que representa o conteúdo.
	 * @return string
	 */
	public function getFileName() : string
	{
		return $this->short_name;
	}
}
