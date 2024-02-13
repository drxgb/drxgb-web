<script setup>
import { ref } from 'vue';

const model = defineModel();
const input = ref(null);

defineExpose({
	input,
});
</script>

<template>
	<select ref="input" class="xgb-input group/input:rounded-s-md" v-model="model">
		<slot />
	</select>
</template>
