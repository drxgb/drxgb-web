<script setup>
import { computed, onMounted, ref } from 'vue';

const props = defineProps({
	type: {
		type: String,
		default: 'info',
	},
	size: {
		type: String,
		default: '',
	},
	timeout: {
		default: 0,
	},
	canClose: {
		type: Boolean,
		default: false,
	},
});

const show = ref(true);

const icon = computed(() => {
	switch (props.type) {
		case 'info':
			return 'circle-info';
		case 'warning':
			return 'triangle-exclamation';
		case 'danger':
			return 'times-circle';
		case 'success':
			return 'circle-check';
	}
});

const defaultClass =
	'flex justify-between items-center gap-8 border-2 rounded-md px-8 py-4';
const colorClass = computed(() => {
	switch (props.type) {
		case 'info':
			return 'text-blue-700 bg-blue-300 border-blue-500';
		case 'warning':
			return 'text-amber-600 bg-amber-300 border-amber-500';
		case 'danger':
			return 'text-red-700 bg-red-300 border-red-500';
		case 'success':
			return 'text-green-700 bg-green-300 border-green-500';
	}
});
const sizeClass = computed(() => {
	switch (props.size) {
		case 'xs':
			return 'w-1/6';
		case 'sm':
			return 'w-2/6';
		case 'md':
			return 'w-3/6';
		case 'lg':
			return 'w-4/6';
		case 'xl':
			return 'w-5/6';
		case 'full':
			return 'w-full';
		default:
			return 'w-auto';
	}
});

onMounted(() => {
	if (props.timeout > 0) {
		const s = Number(props.timeout) * 1000;
		setTimeout(() => (show.value = false), s);
	}
});
</script>

<template>
	<div :class="[defaultClass, sizeClass, colorClass]" v-show="show">
		<font-awesome-icon :icon="['fas', icon]" size="2xl" />
		<div class="w-full">
			<slot />
		</div>
		<font-awesome-icon
			class="cursor-pointer"
			icon="times"
			size="2xl"
			@click="show = false"
		/>
	</div>
</template>
