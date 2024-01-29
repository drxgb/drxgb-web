<script setup>
import { onMounted, ref } from 'vue';

defineProps({
	modelValue: String,
});

const model = defineModel();
const input = ref(null);

onMounted(() => {
	if (input.value.hasAttribute('autofocus')) {
		input.value.focus();
	}
});

defineExpose({focus: () => input.value.focus()});
</script>

<template>
	<textarea
		ref="input"
		class="xgb-input group/input:rounded-s-md"
		v-model="model"
	></textarea>
</template>
