<script setup>
import {computed} from 'vue';
import {Link} from '@inertiajs/vue3';

defineProps({
	href: String,
	type: String,
});

const defaultClass = computed(() => 'block px-4 py-2 text-sm leading-5 transition duration-150 ease-in-out focus:outline-none');
const colorClass = computed(() => 'text-gray-700 dark:text-gray-300 hover:bg-gray-500 hover:text-gray-100 dark:hover:bg-gray-300 dark:hover:text-gray-700 focus:bg-gray-100 dark:focus:bg-gray-800');
</script>

<template>
	<div>
		<button v-if="type == 'button'" type="submit" :class="[defaultClass, colorClass, 'w-full text-start']">
			<slot />
		</button>

		<a v-else-if="type == 'a'" :href="href" :class="[defaultClass, colorClass]">
			<slot />
		</a>

		<Link v-else :href="href" :class="[defaultClass, colorClass]">
		<slot />
		</Link>
	</div>
</template>
