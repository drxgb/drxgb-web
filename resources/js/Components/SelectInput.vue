<script setup>
import { ref } from 'vue';

defineProps({
	modelValue: String,
});

defineEmits([ 'update:modelValue' ]);

const input = ref(null);
</script>

<template>
	<select
		ref="input"
		class="xgb-input group/input:rounded-s-md"
		:value="modelValue"
		@change="$emit('update:modelValue', $event.target.value)"
	>
		<slot />
	</select>
</template>
