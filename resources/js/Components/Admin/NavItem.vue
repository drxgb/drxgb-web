<script setup>
import { ref, computed, reactive } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import NavSubItem from './NavSubItem.vue';

const props = defineProps({
	nav: Object,
	noLabel: {
		type: Boolean,
		default: false,
	}
});
const page = usePage();

const opened = ref(false);
const dropdownIcon = computed(() => opened.value === true ? 'chevron-down' : 'chevron-left');
const itemClass = reactive({
	'bg-orange-600 text-orange-100 hover:text-orange-100 shadow-md':
		page.props.ziggy.location === props.nav.href || opened
});
</script>

<template>
	<Link
		v-if="!nav.items"
		:href="nav.href"
		:title="nav.title"
		class="block px-4 py-2 relative hover:text-blue-200 duration-100 rounded-md"
		:class="itemClass">
		<font-awesome-icon :icon="nav.icon" size="lg" />
		<template v-if="!noLabel">
			<span class="ml-2 text-lg">{{ nav.title }}</span>
		</template>
	</Link>

	<span v-else class="relative">
		<div
			class="flex items-center px-4 py-2 hover:text-blue-200 hover:cursor-pointer duration-100 rounded-md"
			:title="nav.title"
			:class="itemClass"
			@click="opened = !opened">
			<font-awesome-icon :icon="nav.icon" size="lg" />
			<template v-if="!noLabel">
				<span class="ml-2 text-lg">{{ nav.title }}</span>
			</template>

			<font-awesome-icon
				v-if="nav.items && !noLabel"
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
			<div
				v-show="opened"
				class="origin-top"
				:class="{
					'ml-8': !noLabel,
					'absolute top-0 left-12 w-60 bg-blue-500': noLabel,
				}">
				<div v-if="noLabel" class="px-2 py-1 shadow-md bg-orange-600">
					<h3 class="text-3xl">{{ nav.title }}</h3>
				</div>
				<menu v-if="nav.items">
					<li v-for="item of nav.items" class="py-1" :class="{ 'pl-4': noLabel }">
						<NavSubItem :item="item" />
					</li>
				</menu>
			</div>
		</transition>
	</span>
</template>
