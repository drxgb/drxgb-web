<script setup>
import Button from '@/Components/Button.vue';
import InputGroup from '@/Components/InputGroup.vue';

const props = defineProps({
	id: {
		type: String,
		default: '',
	},
	color: {
		type: String,
		default: 'primary',
	},
	min: {
		default: Number.MIN_VALUE,
	},
	max: {
		default: Number.MAX_VALUE,
	},
	step: {
		default: 1,
	},
});
const model = defineModel();

function increment() {
	const next = model.value + props.step;
	if (next <= props.max) model.value += props.step;
}

function decrement() {
	const prev = model.value - props.step;
	if (prev >= props.min) model.value -= props.step;
}
</script>

<template>
	<InputGroup>
		<input
			class="xgb-input max-w-24 sm:max-w-48 text-right"
			type="number"
			v-model.number="model"
			:id="id"
			:min="min"
			:max="max"
			:step="step"
		/>
		<Button type="button" :color="color" icon="plus" @click.prevent="increment" />
		<Button type="button" :color="color" icon="minus" @click.prevent="decrement" />
	</InputGroup>
</template>
