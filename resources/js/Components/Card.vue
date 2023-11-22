<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({
	noPadding: {
		type: Boolean,
		default: false,
	},
});

const classes = computed(() => {
	const style = 'w-full sm:max-w-md mt-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg';

	return style.concat(props.noPadding ? '' : ' px-6 py-4');
});
</script>


<template>
	<div :class="classes">
		<slot />
	</div>
</template>
