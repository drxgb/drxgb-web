<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ __('maintenance.title') }} - {{ config('app.name', 'Laravel') }}</title>

	<!-- CSS -->
	@vite(['resources/css/app.css'])

	<style>
		body {
			background: url('img/bg/0.png');
		}
	</style>
</head>

<body class="font-sans antialiased h-screen relative dark:text-white">
	<main class="flex flex-col h-full justify-center">
		<section class="flex gap-4 w-1/3 mx-auto bg-purple-500 rounded-md shadow-md px-8 py-4 text-purple-50">
			<div class="flex items-center justify-center">
				<img class="w-[144px] antialiased" src="img/chara/blacksmith.gif" alt="blacksmith" />
			</div>
			<div class="w-full">
				<h1 class="text-2xl my-2">{{ __('maintenance.title') }}</h1>
				<p>{{ __('maintenance.message') }}</p>
				<hr class="mt-10 mb-4" />
				<span class="">
					&copy; {{ date('Y') }} -
					{{ __('footer.made_with') }}
					<span class="text-xl">❤️</span>
					{{ __('footer.by_drxgb') }}
				</span>
			</div>
		</section>
	</main>
</body>

</html>
