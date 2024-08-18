<template>
	<div class="flex items-stretch gap-4">
		<div class="flex flex-col justify-center text-right w-1/3 max-w-64 px-2 border-r-2 border-r-slate-100 dark:border-r-slate-600 bg-slate-200 dark:bg-slate-700">
			<slot name="label" />
		</div>
		<div class="w-full">
			<slot />
		</div>
	</div>
</template>
