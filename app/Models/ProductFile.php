<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductFile extends Model
{
    use HasFactory;

	protected $fillable = [
		'name',
		'size',
		'file_path',
	];


	/**
	 * Recebe todas as plataformas suportadas pelo arquivo.
	 * @return BelongsToMany
	 */
	public function platforms() : BelongsToMany
	{
		return $this->belongsToMany(Platform::class);
	}


	/**
	 * Recebe a versão do produto.
	 * @return BelongsTo
	 */
	public function version() : BelongsTo
	{
		return $this->belongsTo(Version::class);
	}
}
