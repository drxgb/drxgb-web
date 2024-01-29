<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreVersionRequest;
use App\Models\Platform;
use Illuminate\Validation\Rules\File;

class VersionController extends AdminController
{
    public function store(StoreVersionRequest $request)
	{
		$version = [
			'number'		=> $request->number,
			'fixes'			=> $request->fixes,
			'release_notes'	=> $request->release_notes,
			'release_date'	=> $request->release_date,
			'files'			=> $request->version_files,
		];

		foreach ($version['files'] as $f => $file)
		{
			$platforms = Platform::whereIn('id', $file['platform_ids'])->get();
			$extensions = array_map(function (array $platform): array
			{
				return array_map(
					fn (array $extension): string => $extension['extension'],
					$platform['supported_file_extensions']
				);
			}, $platforms->toArray());

			$supportedExtensions = [];
			foreach ($extensions as $extension)
			{
				array_push($supportedExtensions, ...$extension);
			}

			$rules["version_files.$f.file"] = [
				'required',
				File::types(array_unique($supportedExtensions)),
			];

			unset($version['files'][$f]['file']);
		}

		$request->validate($rules);
		return redirect()->back()->with('version', $version);
	}
}
