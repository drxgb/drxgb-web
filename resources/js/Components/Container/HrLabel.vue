<template>
	<div class="flex justify-center items-center gap-4 w-full">
		<hr class="dark:border-b-gray-300 w-full" />
		<slot />
		<hr v-if="$slots.default" class="dark:border-b-gray-300 w-full" />
	</div>
</template>
