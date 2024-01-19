<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileExtension;
use Illuminate\Http\Request;

class FileExtensionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->view($request, 'Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FileExtension $fileExtension)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileExtension $fileExtension)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FileExtension $fileExtension)
    {
        //
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
		return 'Admin/Files/FileExtensions';
	}
}
