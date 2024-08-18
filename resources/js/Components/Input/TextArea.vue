<script setup>
import { onMounted, ref } from 'vue';

defineProps({
	modelValue: String,
});

const model = defineModel();
const input = ref(null);

onMounted(() =>
{
	if (input.value.hasAttribute('autofocus'))
	{
		input.value.focus();
	}
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
	<textarea v-model="model"
		ref="input"
		class="xgb-input group/input:rounded-s-md"
	></textarea>
</template>
