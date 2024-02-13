<script setup>
import { reactive } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
	items: Array,
	color: {
		type: String,
		default: 'primary',
	},
});

const colorClass = reactive({
	'text-orange-700 hover:text-orange-600 dark:text-orange-300 dark:hover:text-orange-400':
		props.color === 'primary',
	'text-purple-700 hover:text-purple-600 dark:text-purple-300 dark:hover:text-purple-400':
		props.color === 'secondary',
});
</script>

<template>
	<menu class="flex flex-wrap">
		<li v-for="(item, index) in items">
			<Link
				v-if="item.url"
				:href="item.url"
				class="text-sm duration-100"
				:class="colorClass"
			>
				{{ item.label }}
			</Link>
			<span v-else class="text-gray-700 dark:text-gray-300 text-sm">
				{{ item.label }}
			</span>

			<font-awesome-icon
				v-if="index < items.length - 1"
				class="mx-4 text-gray-500 dark:text-gray-400"
				size="sm"
				icon="chevron-right"
			/>
		</li>
	</menu>
</template>
