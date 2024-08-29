<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VersionRequest;


class VersionController extends AdminController
{
    public function save(VersionRequest $request)
	{
		$version = [
			'number'		=> $request->number,
			'release_notes'	=> $request->release_notes,
			'release_date'	=> $request->release_date,
			'fixes'			=> $request->fixes,
			'files'			=> array_map(
				function (array $file) : array
				{
					// Arquivos são removidos porque não devem ser serializados
					unset($file['product_file']);
					return $file;
				},
				$request->version_files
			),
		];

		return redirect()->back()->with('version', $version);
	}
}
