<script setup>
import { reactive } from 'vue';

const props = defineProps({
	from: {
		type: String,
		default: 'up',
	},
	duration: {
		type: Number,
		default: 200,
	}
});

const start = reactive({
	duration: `transition ease-out duration-${props.duration}`,
	left: 'transform -translate-x-full',
	right: 'transform translate-x-full',
	up: 'transform -translate-y-full',
	down: 'transform translate-y-full',
});

const end = reactive({
	duration: `transition ease-in duration-${props.duration}`,
	left: 'transform translate-x-0',
	right: 'transform translate-x-0',
	up: 'transform translate-y-0',
	down: 'transform translate-y-0',
});
</script>


<template>
	<transition
		:enter-active-class="start.duration"
		:enter-from-class="start[from]"
		:enter-to-class="end[from]"
		:leave-active-class="end.duration"
		:leave-from-class="end[from]"
		:leave-to-class="start[from]"
	>
		<slot />
	</transition>
</template>
