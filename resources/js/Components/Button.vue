<script setup>
import {computed} from 'vue';

const props = defineProps({
	type: {
		type: String,
		default: 'submit',
	},
	color: String,
	class: {
		type: String,
		default: null,
	},
	fa: {
		type: String,
		default: 'fas',
	},
	href: String,
	icon: String,
	size: {
		type: String,
		default: 'xs',
	},

});

const defaultClass = 'inline-flex items-center uppercase justify-center gap-2 px-4 py-2 border border-transparent rounded-md font-semibold tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150';
const btnClass = computed(() => props.class);
const colorClass = computed(() => {
	switch (props.color) {
		case 'custom':
			return '';
		case 'primary':
			return 'text-white bg-orange-500 hover:bg-orange-700 focus:bg-orange-200 active:bg-orange-300';
		case 'secondary':
			return 'text-white bg-purple-700 hover:bg-purple-900 focus:bg-purple-400 active:bg-purple-500';
		case 'success':
			return 'text-white bg-green-500 hover:bg-green-700 focus:bg-green-200 active:bg-green-300';
		case 'info':
			return 'text-white bg-blue-500 hover:bg-blue-700 focus:bg-blue-200 active:bg-blue-300';
		case 'warning':
			return 'text-white bg-amber-500 hover:bg-amber-700 focus:bg-amber-200 active:bg-amber-300';
		case 'danger':
			return 'text-white bg-red-500 hover:bg-red-700 focus:bg-red-200 active:bg-red-300';
		default:
			return 'text-white bg-slate-700 hover:bg-slate-900 focus:bg-slate-400 active:bg-slate-500';
	}
});
const sizeClass = computed(() => `text-${props.size}`);
const iconSize = computed(() => {
	switch (props.size) {
		case 'xxs':
			return 'xs';
		case 'xs':
			return null;
		case '2xl':
			return 'xl';
		case '3xl':
		case '4xl':
		case '5xl':
		case '6xl':
			return '2xl';
		default:
			return props.size;
	}
});
</script>


<template>
	<a v-if="href" :href="href" :class="[defaultClass, colorClass, sizeClass, btnClass]">
		<font-awesome-icon v-if="icon" :icon="[fa, icon]" :size="iconSize" />
		<slot />
	</a>

	<button v-else :class="[defaultClass, colorClass, sizeClass, btnClass]">
		<font-awesome-icon v-if="icon" :icon="[fa, icon]" :size="iconSize" />
		<slot />
	</button>
</template>
