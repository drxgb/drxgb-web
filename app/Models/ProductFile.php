<?php

namespace App\Models;

use App\Utils\Upload;
use App\Contracts\Storeable;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductFile extends Model
	implements Storeable
{
    use HasFactory;

	protected $fillable = [
		'name',
		'size',
		'file_path',
	];


	/**
	 * Recebe todas as plataformas suportadas pelo arquivo.
	 * @return BelongsToMany
	 */
	public function platforms() : BelongsToMany
	{
		return $this->belongsToMany(Platform::class);
	}


	/**
	 * Recebe a versão do produto.
	 * @return BelongsTo
	 */
	public function version() : BelongsTo
	{
		return $this->belongsTo(Version::class);
	}


	/**
	 * Recebe a pasta raiz do conteúdo.
	 * @return string
	 */
	public function getRootFolder() : string
	{
		return Upload::makePath('product-files', $this->id);
	}


	/**
	 * Recebe o nome do arquivo que representa o conteúdo.
	 * @return string
	 */
	public function getFileName() : string
	{
		return $this->name ?? $this->file_path;
	}


	/**
	 * Salva o arquivo
	 * @param UploadedFile $file
	 * @return void
	 */
	public function saveFile(UploadedFile $file) : void
	{
		$filename = pathinfo($this->name, PATHINFO_FILENAME);
		$filename .= '.' . $file->getClientOriginalExtension();
		$file->storePubliclyAs($this->getRootFolder(), $filename, 'public');
		$this->file_path = $filename;
	}
}
