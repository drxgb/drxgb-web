<script setup>
defineProps({
	type: {
		type: String,
		default: 'submit',
	},
	icon: String,
	fa: {
		type: String,
		default: 'fas',
	},
});
</script>

<template>
	<button :type="type" class="inline-flex items-center px-4 py-2 bg-orange-500 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-orange-700 focus:bg-orange-400 active:bg-orange-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
		<font-awesome-icon v-if="icon" :icon="[fa, icon]" class="mr-2" />
		<slot />
	</button>
</template>
