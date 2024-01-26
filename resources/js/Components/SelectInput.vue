<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
	value: {
		default: null,
	},
	multiple: {
		type: Boolean,
		default: false,
	},
});
const emit = defineEmits(['change-option']);

const input = ref(null);

onMounted(() => {
	if (props.multiple) {
		[ ...input.value.options ].forEach(option => {
			if (props.value.find(v => v == option.value)) {
				option.selected = true;
			}
		});
	} else if(props.value) {
		input.value.value = props.value;
	}
});


function update() {
	if (props.multiple) {
		const options = [...input.value.options]
			.filter(option => option.selected)
			.map(option => option.value);
		emit('change-option', options);
	}
	else
		emit('change-option', input.value.value);
}
</script>

<template>
	<select
		ref="input"
		class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm group/input:rounded-s-md"
		:multiple="multiple"
		@change="update()"
	>
		<slot />
	</select>
</template>
