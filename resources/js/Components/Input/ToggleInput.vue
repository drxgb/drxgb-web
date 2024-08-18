<script setup>
import { reactive } from 'vue';

const props = defineProps({
	id: {
		type: String,
		default: '',
	},
	color: {
		type: String,
		default: 'primary',
	},
});
const model = defineModel();
const checkClass = reactive({
	primary: 'peer-checked:bg-orange-500',
	secondary: 'peer-checked:bg-purple-700',
	success: 'peer-checked:bg-green-500',
	info: 'peer-checked:bg-blue-500',
	warning: 'peer-checked:bg-amber-500',
	danger: 'peer-checked:bg-red-500',
});
</script>

<template>
	<label class="relative inline-block w-[60px] h-[32px]">
		<input v-model="model"
			type="checkbox"
			class="hidden peer"
			:id="id"
			true-value="yes"
			false-value="no"
		/>
		<span
			class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 duration-300 rounded-full bg-gray-300 dark:bg-gray-500 before:absolute before:w-[26px] before:h-[26px] before:left-[4px] before:top-[3px] before:bg-white before:rounded-full before:duration-300 peer-checked:before:translate-x-[26px]"
			:class="checkClass[color]"
		/>
	</label>
</template>
