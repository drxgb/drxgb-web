<script setup>
import {computed, ref} from 'vue';

const props = defineProps({
	fontSize: {
		type: String,
		default: 'xs',
	}
});
const show = ref(false);
const sizeClass = computed(() => `text-${props.fontSize}`);
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
			<div v-show="show"
				:class="sizeClass"
				class="absolute text-center z-50 -left-1/2 text-slate-900 dark:text-slate-100 bg-slate-300 border-slate-400 dark:bg-slate-800 dark:border-slate-500 border-2 rounded-md px-2 py-1 shadow-md"
			>
				<slot />
			</div>
		</transition>
	</div>
</template>
