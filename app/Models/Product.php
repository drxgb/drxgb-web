<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
	 * @return HasMany
	 */
	public function versions() : HasMany
	{
		return $this->hasMany(Version::class);
	}
}
