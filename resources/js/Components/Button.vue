<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
	type: {
		type: String,
		default: 'submit',
	},
	color: String,
	href: String,
	icon: String,
	fa: {
		type: String,
		default: 'fas',
	},
});

const page = usePage();
const classes = computed(() => {
	let style = 'inline-flex items-center justify-center gap-2 px-4 py-2 border border-transparent rounded-md font-semibold text-xs tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150';

	switch (props.color) {
		case 'custom':
			break;
		case 'primary':
			style = style.concat(' text-white bg-orange-500 hover:bg-orange-700 focus:bg-orange-200 active:bg-orange-300');
			break;
		case 'info':
			style = style.concat(' text-white bg-blue-500 hover:bg-blue-700 focus:bg-blue-200 active:bg-blue-300');
			break;
		default:
			style = style.concat(' text-white bg-slate-700 hover:bg-slate-900 focus:bg-slate-400 active:bg-slate-500');
	}

	return style;
});
</script>


<template>
	<template v-if="href">
		<a :href="href" :class="classes">
			<font-awesome-icon v-if="icon" :icon="[fa, icon]" />
			<span>
				<slot />
			</span>
		</a>
	</template>

	<template v-else>
		<button :class="classes">
			<font-awesome-icon v-if="icon" :icon="[fa, icon]" />
			<span>
				<slot />
			</span>
		</button>
	</template>
</template>
