<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Version extends Model
{
    use HasFactory;

	protected $fillable = [
		'number',
		'fixes',
		'release_notes',
	];


	/**
	 * Recebe os arquivos pertencentes a esta versão.
	 * @return HasMany
	 */
	public function productFiles() : HasMany
	{
		return $this->hasMany(ProductFile::class);
	}


	/**
	 * Recebe o produto desta versão.
	 * @return HasOne
	 */
	public function product() : HasOne
	{
		return $this->hasOne(Product::class);
	}
}
