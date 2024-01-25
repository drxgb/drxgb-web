<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
	item: Object,
});
const emit = defineEmits([ 'active' ]);
const page = usePage();

const opened = ref(false);
const dropdownIcon = computed(() => opened.value === true ? 'chevron-down' : 'chevron-left');
const activeClass = reactive({
	'bg-orange-600 text-orange-100 hover:text-orange-100 shadow-md':
		isActive() || opened,
});


onMounted(() => {
	if (isActive()) {
		onActive();
	}
});


function isActive() {
	return props.item.active;
}


function onActive() {
	opened.value = true;
	emit('active');
}
</script>

<template>
	<li class="mt-1 px-2 rounded-sm" :class="activeClass">
		<Link
			v-if="!item.items"
			:href="item.href"
			class="hover:text-blue-200 duration-100"
			:class="activeClass"
		>
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
					<NavSubItem
						v-for="i of item.items"
						:item="i"
						@active="onActive"
					/>
				</menu>
			</transition>
		</span>
	</li>
</template>
