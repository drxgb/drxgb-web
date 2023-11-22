<template>
	<div class="flex items-stretch">
		<div class="flex flex-col justify-center text-right w-1/3 px-2 border-r-2 border-r-slate-50 dark:border-r-slate-600 bg-slate-100 dark:bg-slate-700">
			<slot name="label" />
		</div>
		<div class="w-2/3 pl-4">
			<slot />
		</div>
	</div>
</template>
