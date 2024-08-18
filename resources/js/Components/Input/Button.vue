<script setup>
import { computed } from 'vue';

const props = defineProps({
	type: {
		type: String,
		default: 'submit',
	},
	color: String,
	class: {
		type: String,
		default: '',
	},
	fa: {
		type: String,
		default: 'fas',
	},
	href: String,
	icon: {
		default: null,
	},
	size: {
		type: String,
		default: 'xs',
	},

});

const defaultClass = 'inline-flex items-center uppercase justify-center gap-2 px-4 py-2 border border-transparent rounded-md font-semibold tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150';
const btnClass = computed(() => props.class);
const colorClass = computed(() =>
{
	if (props.color)
	{
		return `input-${props.color}`;
	}
	return 'text-white bg-slate-700 hover:bg-slate-900 focus:bg-slate-400 active:bg-slate-500';
});
const sizeClass = computed(() => `text-${props.size}`);
const iconSize = computed(() =>
{
	switch (props.size)
	{
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
	<a v-if="href"
		:href="href"
		:class="[ defaultClass, colorClass, sizeClass, btnClass ]"
	>
		<font-awesome-icon v-if="icon"
			:icon="[ fa, icon ]"
			:size="iconSize"
		/>
		<slot />
	</a>

	<button v-else
		:class="[ defaultClass, colorClass, sizeClass, btnClass ]"
	>
		<font-awesome-icon v-if="icon"
			:icon="[ fa, icon ]"
			:size="iconSize"
		/>
		<slot />
	</button>
</template>
