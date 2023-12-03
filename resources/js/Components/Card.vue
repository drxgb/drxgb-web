<script setup>
import { computed } from 'vue';

const props = defineProps({
	noPadding: {
		type: Boolean,
		default: false,
	},
	size: {
		type: String,
		default: 'sm',
	},
});

const defaultClass = computed(() =>
	'mt-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg');
const padding = computed(() => props.noPadding ? '' : ' px-6 py-4');
const sizeClass = computed(() => {
	switch (props.size) {
		case 'xs': return 'w-1/4';
		case 'sm': return 'w-1/3';
		case 'md': return 'w-1/2';
		case 'lg': return 'w-2/3';
		case 'xl': return 'w-5/6';
	}
});
</script>


<template>
	<div :class="[ defaultClass, padding, sizeClass ]">
		<slot />
	</div>
</template>
