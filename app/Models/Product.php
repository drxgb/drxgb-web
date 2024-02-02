<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
		'cover_index',
	];


	protected $casts = [
		'active'	=> 'boolean',
	];


	protected $appends = [
		'cover',
		'images',
		'related_category',
		'related_versions',
	];


	/**
	 * Recebe a imagem da capa.
	 * @return Attribute<string>
	 */
	public function cover() : Attribute
	{
		return Attribute::get(fn () : string => '');
	}


	/**
	 * Recebe as imagens do produto.
	 * @return Attribute<array>
	 */
	public function images() : Attribute
	{
		return Attribute::get(fn () : array => []);
	}


	/**
	 * Recebe as versões do produto.
	 * @return Attribute<Collection<Version>>
	 */
	public function relatedVersions() : Attribute
	{
		return Attribute::get(fn () : Collection => $this->versions()->get());
	}


	/**
	 * Recebe a categoria no qual o produto pertence.
	 * @return Attribute<?Category>
	 */
	public function relatedCategory() : Attribute
	{
		return Attribute::get(
			fn () : ?Category =>
				$this->category_id
					? Category::find($this->category_id)
					: null
		);
	}


	/**
	 * Recebe as versões relacionadas.
	 * @return HasMany<Version>
	 */
	public function versions() : HasMany
	{
		return $this->hasMany(Version::class);
	}


	/**
	 * Recebe a categoria na qual pertence.
	 * @return BelongsTo<Category>
	 */
	public function category() : BelongsTo
	{
		return $this->belongsTo(Category::class);
	}
}
