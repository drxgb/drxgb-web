<?php

namespace App\Models;

use App\Utils\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

	protected $fillable = [
		'title',
		'slug',
		'page',
		'description',
		'price',
		'active',
	];


	/**
	 * Recebe as versões do produto.
	 * @param bool $useRelation
	 * @return Attribute|HasMany
	 */
	public function versions(bool $useRelation = false) : Attribute|HasMany
	{
		return Models::getAttributeOrRelation($this->hasMany(Version::class), $useRelation);
	}


	/**
	 * Recebe as imagens do produto.
	 * @param bool $useRelation
	 * @return Attribute|HasMany
	 */
	public function images(bool $useRelation = false) : Attribute|HasMany
	{
		return Models::getAttributeOrRelation($this->hasMany(ProductImage::class), $useRelation);
	}


	/**
	 * Recebe a categoria no qual o produto pertence.
	 * @param bool $useRelation
	 * @return Attribute|BelongsTo
	 */
	public function category(bool $useRelation = false) : Attribute|BelongsTo
	{
		return Models::getAttributeOrRelation($this->belongsTo(Category::class), $useRelation);
	}


	/**
	 * Recebe a capa do produto.
	 * @param bool $useRelation
	 * @return Attribute|HasOne
	 */
	public function cover(bool $useRelation = false) : Attribute|HasOne
	{
		return Models::getAttributeOrRelation($this->hasOne(ProductImage::class), $useRelation);
	}
}
