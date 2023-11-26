<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
	align: {
		type: String,
		default: 'right',
	},
	size: {
		type: String,
		default: 'sm',
	},
	contentClasses: {
		type: Array,
		default: () => ['bg-white dark:bg-gray-700'],
	},
});

const open = ref(false);

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const widthClass = computed(() => {
	return {
		'sm': 'w-48',
		'md': 'w-64',
		'lg': 'w-72',
	}[props.size.toString()];
});
const alignmentClasses = computed(() => {
	if (props.align === 'left') {
		return 'ltr:origin-top-left rtl:origin-top-right start-0';
	}

	if (props.align === 'right') {
		return 'ltr:origin-top-right rtl:origin-top-left end-0';
	}

	return 'origin-top';
});

function closeOnEscape(e) {
	if (open.value && e.key === 'Escape') {
		open.value = false;
	}
};
</script>

<template>
	<div class="relative">
		<div @click="open = !open" class="hover:cursor-pointer">
			<slot name="trigger" />
		</div>

		<!-- Full Screen Dropdown Overlay -->
		<div v-show="open" class="fixed inset-0 z-40" @click="open = false" />

		<transition
			enter-active-class="transition ease-out duration-200"
			enter-from-class="transform opacity-25 scale-y-0"
			enter-to-class="transform opacity-100 scale-y-100"
			leave-active-class="transition ease-in duration-100"
			leave-from-class="transform opacity-100 scale-y-100"
			leave-to-class="transform opacity-25 scale-y-0">
			<div
				v-show="open"
				class="absolute z-50 mt-2 rounded-md shadow-lg origin-top"
				:class="[widthClass, alignmentClasses]"
				style="display: none;">
				<div class="rounded-md ring-1 ring-black ring-opacity-5" :class="contentClasses">
					<slot name="content" />
				</div>
			</div>
		</transition>
	</div>
</template>
