<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class DashboardController extends AdminController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return $this->view('Dashboard');
    }
}
