<script setup>
import { reactive } from 'vue';

const props = defineProps({
	label: String,
	url: {
		type: String,
		default: '',
	},
	active: {
		type: Boolean,
		default: false,
	},
	isIcon: {
		type: Boolean,
		default: false,
	},
	fa: {
		type: String,
		default: 'fas',
	},
});

const linkClass = 'px-2 py-1 border border-y-2 first:rounded-l-md last:rounded-r-md first:border-l-2 last:border-r-2';
const hoverClass = 'hover:border-orange-500 hover:bg-orange-400 duration-200 hover:text-orange-50';
const colorClass = reactive({
	'bg-orange-400 border-orange-500 text-orange-50': props.active,
	'border-slate-500 bg-slate-200 dark:border-slate-500 dark:bg-slate-600': !props.active,
});
</script>

<template>
	<a v-if="url && !active" :href="url" :class="[ linkClass, hoverClass, colorClass ]">
		<font-awesome-icon v-if="isIcon" :icon="[ fa, label ]" />
		<template v-else>
			{{ label }}
		</template>
	</a>
	<span v-else :class="[ linkClass, colorClass ]">
		<font-awesome-icon v-if="isIcon" :icon="[fa, label]" />
		<template v-else>
			{{ label }}
		</template>
	</span>
</template>
