<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

	protected $fillable = [
		'name',
	];


	/**
	 * Recebe a categoria pai.
	 * @return HasOne
	 */
	public function parent() : HasOne
	{
		return $this->hasOne(Category::class, 'parent_id');
	}


	/**
	 * Recebe as subcategorias.
	 * @return BelongsTo
	 */
	public function subcategories() : BelongsTo
	{
		return $this->belongsTo(Category::class, 'parent_id');
	}
}
