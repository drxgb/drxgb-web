<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Breadcrumb;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends AdminController
	implements Breadcrumb
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render($this->view('Dashboard'), [
			'breadcrumbs'	=> $this->makeBreadcrumbs($request),
		]);
    }


	/**
	 * @param Request $request
	 * @return array<array<string, string>>
	 */
	public function makeBreadcrumbs(Request $request): array
	{
		return [
			[
				'label'	=> __('dashboard'),
			],
		];
	}
}
