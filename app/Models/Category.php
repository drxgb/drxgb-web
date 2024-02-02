<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

	protected $fillable = [
		'name',
	];

	protected $appends = [
		'children',
	];


	/**
	 * Recebe a categoria pai.
	 * @return BelongsTo
	 */
	public function parent() : BelongsTo
	{
		return $this->belongsTo(Category::class, 'parent_id');
	}


	/**
	 * Recebe as subcategorias.
	 * @return HasMany
	 */
	public function subcategories() : HasMany
	{
		return $this->hasMany(Category::class, 'parent_id');
	}


	/**
	 * Recebe as subcategorias em forma de atributo.
	 * @return Attribute<Collection<Category>>
	 */
	public function children() : Attribute
	{
		return Attribute::get(fn () : Collection => $this->subcategories()->get());
	}


	/**
	 * Recebe os produtos da categoria.
	 * @return HasMany
	 */
	public function products() : HasMany
	{
		return $this->hasMany(Product::class);
	}
}
