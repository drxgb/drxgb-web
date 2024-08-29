<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Version extends Model
{
    use HasFactory;

	protected $fillable = [
		'number',
		'release_date',
		'release_notes',
		'fixes',
	];


	protected $appends = [
		'files',
	];


	/**
	 * Recebe os arquivos pertencentes a esta versão.
	 *
	 * @return HasMany
	 */
	public function productFiles() : HasMany
	{
		return $this->hasMany(ProductFile::class);
	}


	/**
	 * Recebe o produto desta versão.
	 *
	 * @return BelongsTo
	 */
	public function product() : BelongsTo
	{
		return $this->belongsTo(Product::class);
	}


	/**
	 * Recebe os arquivos da versão.
	 *
	 * @return Attribute
	 */
	public function files() : Attribute
	{
		return Attribute::get(fn () : Collection => $this->productFiles()->get());
	}


	/**
	 * @return array
	 */
	protected function casts() : array
	{
		return [
			'release_date'	=> 'datetime:M jS, Y',
		];
	}
}
