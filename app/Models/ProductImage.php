<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;


	protected $fillable = [
		'title',
		'path',
	];


	/**
	 * Recebe o link da imagem do produto.
	 * @return Attribute
	 */
	public function image() : Attribute
	{
		return Attribute::get(fn () => $this->path);
	}
}
