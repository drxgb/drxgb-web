<script setup>
import { computed, ref } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps({
	item: Object,
});

const opened = ref(false);
const dropdownIcon = computed(() => opened.value === true ? 'chevron-down' : 'chevron-left');
</script>

<template>
	<Link v-if="!item.items" :href="item.href" class="hover:text-blue-200 duration-100">
		<span class="text-lg">{{ item.title }}</span>
	</Link>

	<span v-else>
			<div
				class="flex items-center pr-4 py-2 hover:text-blue-200 hover:cursor-pointer duration-100 rounded-md"
				@click="opened = !opened">
				<span class="text-lg">{{ item.title }}</span>

				<font-awesome-icon
					v-if="item.items"
					class="ml-auto"
					:icon="dropdownIcon" />
			</div>

			<transition
					enter-active-class="transition ease-out duration-200"
					enter-from-class="transform opacity-25 scale-y-0"
					enter-to-class="transform opacity-100 scale-y-100"
					leave-active-class="transition ease-in duration-100"
					leave-from-class="transform opacity-100 scale-y-100"
					leave-to-class="transform opacity-25 scale-y-0">
				<menu v-if="item.items" v-show="opened" class="origin-top ml-4">
					<li v-for="i of item.items" class="py-1">
						<NavSubItem :item="i" />
					</li>
				</menu>
			</transition>
		</span>
</template>
