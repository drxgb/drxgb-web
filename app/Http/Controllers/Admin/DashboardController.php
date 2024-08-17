<?php

namespace App\Http\Controllers\Admin;

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
