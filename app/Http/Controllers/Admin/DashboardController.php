<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class DashboardController extends AdminController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return $this->view($request, 'Dashboard');
    }
}
