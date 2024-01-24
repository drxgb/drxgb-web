<?php

namespace App\Repositories;

use App\Models\FileExtension;
use App\Models\Platform;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PlatformRepository
{
	use HasIcon;

	/**
	 * Recebe a lista das extensões em ordem alfabética.
	 * @param ?string $sort
	 * @return array<FileExtension>
	 */
	public function extensions(?string $sort = null) : array
	{
		$extensions = FileExtension::all();
		if ($sort)
			$extensions = $extensions->sortBy($sort);
		return array_values($extensions->toArray());
	}


	/**
	 * Crua uma nova plataforma.
	 * @param Request $request
	 * @return Platform
	 */
	public function store(Request $request) : Platform
	{
		$platform = Platform::create([
			'name'			=> $request->name,
			'short_name'	=> $request->short_name,
		])
			->fileExtensions()
			->attach($request->file_extensions);

		$this->uploadIconIfNeeded($request, $platform);
		if ($platform->isDirty())
			$platform->save();

		return $platform;
	}


	/**
	 * Atualiza uma plataforma.
	 * @param Request $request
	 * @param Platform $platform
	 * @return void
	 */
	public function update(Request $request, Platform $platform) : void
	{
		$platform->update([
			'name'			=> $request->name,
			'short_name'	=> $request->short_name,
		]);
		$platform->fileExtensions()->sync($request->file_extensions);

		$this->uploadIconIfNeeded($request, $platform);
		$this->deleteIconIfNeeded($request, $platform);
		$platform->save();
	}


	/**
	 * Remove uma plataforma.
	 * @param Platform $platform
	 * @return void
	 */
	public function delete(Platform $platform) : void
	{
		$platform->fileExtensions()->detach();
		$platform->delete();
		$platform->deleteIcon();
	}
}
