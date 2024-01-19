<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends Model
{
    use HasFactory;

	protected $fillable = [
		'name',
		'short_name',
		'icon_path',
	];


	/**
	 * Recebe as extensões suportadas por esta plataforma.
	 * @return BelongsToMany
	 */
	public function fileExtensions(): BelongsToMany
	{
		return $this->belongsToMany(FileExtension::class);
	}
}
