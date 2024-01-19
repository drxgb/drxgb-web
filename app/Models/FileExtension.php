<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileExtension extends Model
{
    use HasFactory;

	protected $fillable = [
		'name',
		'extension',
		'icon_path',
	];
}
