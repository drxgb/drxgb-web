<script setup lang="ts">
import { computed } from 'vue';


const props = defineProps({
	id: String,
	name: String,
	value: String,
	modelValue: null,
	color: {
		type: String,
		default: 'primary',
	}
});
const emit = defineEmits([
	'update:modelValue',
]);

const colorClass = computed(() => {
	switch (props.color) {
		case 'primary':
			return 'text-orange-600';
		case 'secondary':
			return 'text-purple-700';
	}
});
</script>


<template>
	<div class="inline-flex items-center gap-2">
		<input
			type="radio"
			:class="[ colorClass ]"
			:id="id"
			:name="name"
			:value="value"
			@change="$emit('update:modelValue', $event.target.value)"
		/>
		<label :for="id">
			<slot />
		</label>
	</div>
</template>
