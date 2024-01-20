<?php

namespace App\Http\Controllers\Admin;

use App\Models\FileExtension;
use App\Http\Requests\StoreFileExtensionRequest;
use App\Http\Requests\UpdateFileExtensionRequest;
use App\Services\FileExtensionService;

class FileExtensionController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		$extensions = FileExtension::paginate(20);
        return $this->view('Index', compact('extensions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view('Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileExtensionRequest $request)
    {
		$service = new FileExtensionService;
		$service->store($request);

        return to_route('admin.file-extensions.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileExtension $fileExtension)
    {
        return $this->view('Form', compact('fileExtension'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileExtensionRequest $request, FileExtension $fileExtension)
    {
		$service = new FileExtensionService;
		$service->update($request, $fileExtension);

		return to_route('admin.file-extensions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FileExtension $fileExtension)
    {
        //
    }


	/**
	 * @return string
	 */
	protected function rootFolder(): string
	{
		return parent::rootFolder() . '/Files/FileExtensions';
	}
}
