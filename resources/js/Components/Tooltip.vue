<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
	position: {
		type: String,
		default: 'bottom',
	}
});

const show = ref(false);

const arrowClass = computed(() => {
	switch (props.position) {
		case 'bottom': return '-top-4 inset-x-1/2 border-x-[12px] border-x-transparent dark:border-x-transparent border-b-[16px]';
	}
});
const positionClass = computed(() => {
	switch (props.position) {
		case 'bottom': return '-left-32 top-8';
	}
});
const defaultClass = 'absolute w-64 text-center bg-slate-300 border-slate-400 dark:bg-slate-800 dark:border-slate-500 border-2 rounded-md px-2 py-1 shadow-md';
</script>


<template>
	<div class="relative" @mouseenter="show = true" @mouseleave="show = false">
		<div class="hover:cursor-pointer">
			<slot name="label" />
		</div>

		<transition
			enter-active-class="ease-out duration-300"
			enter-from-class="opacity-0"
			enter-to-class="opacitiy-100"
			leave-active-class="ease-in duration-300"
			leave-from-class="opacity-100"
			leave-to-class="opacity-0">
			<div v-show="show" :class="[ defaultClass, positionClass ]">
				<span :class="[ arrowClass, 'absolute border-slate-400 dark:border-slate-500' ]" />
				<slot />
			</div>
		</transition>
	</div>
</template>
