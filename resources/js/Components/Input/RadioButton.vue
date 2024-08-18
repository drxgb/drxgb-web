<script setup>
import { reactive, ref } from 'vue';

defineProps({
	color: {
		type: String,
		default: 'primary',
	},
});

const model = defineModel();
const input = ref(null);
const radioColor = reactive({
	primary: 'checked:bg-orange-500 checked:focus:bg-orange-500 checked:hover:bg-orange-500 checked:ring-orange-500',
	secondary: 'checked:bg-purple-500 checked:focus:bg-purple-500 checked:hover:bg-purple-500 checked:ring-purple-500',
	success: 'checked:bg-green-500 checked:focus:bg-green-500 checked:hover:bg-green-500 checked:ring-green-500',
	info: 'checked:bg-blue-500 checked:focus:bg-blue-500 checked:hover:bg-blue-500 checked:ring-blue-500',
	warning: 'checked:bg-amber-500 checked:focus:bg-amber-500 checked:hover:bg-amber-500 checked:ring-amber-500',
	danger: 'checked:bg-red-500 checked:focus:bg-red-500 checked:hover:bg-red-500 checked:ring-red-500',
});

defineExpose({
	click: () => input.value.click(),
	focus: () => input.value.focus(),
});
</script>

<template>
	<input ref="input"
		type="radio"
		class="w-[24px] h-[24px] checked:appearance-none"
		:class="radioColor[color]"
		v-model="model"
	/>
</template>
