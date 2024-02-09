<?php

namespace App\Models;

use App\Utils\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

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
		return Attribute::get(fn () : string =>
			Storage::Url($this->getImages()[$this->cover_index])
		);
	}


	/**
	 * Recebe as imagens do produto.
	 * @return Attribute<array<string>>
	 */
	public function images() : Attribute
	{
		return Attribute::get(function () : array
		{
			return array_map(
				fn (string $file) : string => Storage::url($file),
				$this->getImages()
			);
		});
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


	/**
	 * Retorna um conjunto com as imagens do produto.
	 * @return array
	 */
	public function getImages() : array
	{
		$path = Upload::makePath('product-images', $this->id);
		return Storage::disk('public')->files($path);
	}
}
