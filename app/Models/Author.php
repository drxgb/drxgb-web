<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Author extends Model
{
    use HasFactory;

	protected $fillable = [
		'name',
	];


	/**
	 * Recebe o usuário que representa o autor.
	 *
	 * @return HasOne
	 */
	public function user() : HasOne
	{
		return $this->hasOne(User::class);
	}
}
