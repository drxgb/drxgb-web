<script setup>
import {computed} from 'vue';
import {Link} from '@inertiajs/vue3';

const props = defineProps({
	href: String,
	active: Boolean,
});

const classes = computed(() => {
	return props.active
		? 'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-green-800 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
		: 'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-green-200 hover:text-green-700 focus:outline-none focus:text-green-700 dark:focus:text-green-300 focus:border-green-300 dark:focus:border-green-700 transition duration-150 ease-in-out';
});
</script>

<template>
	<Link :href="href" :class="classes">
	<slot />
	</Link>
</template>
