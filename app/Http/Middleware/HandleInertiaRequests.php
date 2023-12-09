<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
			'appName' => config('app.name'),
			'can'	=> [
				...$this->getUserPermissions($request),
			],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }


	protected function getUserPermissions(Request $request): array
	{
		/** @var User */
		$user = $request->user();

		return [
			'view_dashboard'	=> $user ? $user->isAdmin() : false,
		];
	}
}
