<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


abstract class AdminController extends Controller
{
	protected function viewRootFolder() : string
	{
		return 'Admin';
	}
}
