<script setup>
import { onMounted, ref, computed } from 'vue';
import Button from '@/Components/Input/Button.vue';
import InputGroup from './InputGroup.vue';
import TextInput from './TextInput.vue';

defineProps({
	modelValue: String,
	id: {
		type: String,
		default: null,
	},
	name: {
		type: String,
		default: null,
	},
	autocomplete: {
		type: String,
		default: null,
	},
	placeholder: {
		type: String,
		default: null,
	},
	required: {
		type: Boolean,
		default: false,
	},
});

defineEmits(['update:modelValue']);

const input = ref(null);
const show = ref(false);
const icon = computed(() => show.value === true ? 'fa-eye' : 'fa-eye-slash');
const type = computed(() => show.value === true ? 'text' : 'password');
const color = computed(() => show.value === true ? 'success' : 'secondary');
</script>


<template>
	<InputGroup>
		<TextInput ref="input"
			:type="type"
			class="rounded-r-none w-full"
			:id="id"
			:name="name"
			:value="modelValue"
			:autocomplete="autocomplete"
			:placeholder="placeholder"
			:required="required"
			@input="$emit('update:modelValue', $event.target.value)"
		/>
		<Button type="button"
			class="rounded-l-none py-0"
			:color="color"
			@click.prevent="show = !show"
		>
			<span class="text-2xl">
				{{  show ? '🙉' : '🙈' }}
			</span>
		</Button>
	</InputGroup>
</template>
