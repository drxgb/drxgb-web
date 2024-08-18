<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
	value: {
		default: null,
	},
});
const emit = defineEmits(['change-option']);

const input = ref(null);

onMounted(() =>
{
	if (props.value)
	{
		[ ...input.value.options ].forEach(option =>
		{
			if (props.value.find(v => v == option.value))
			{
				option.selected = true;
			}
		});
	}
});


function update()
{
	const options = [ ...input.value.options ]
		.filter(option => option.selected)
		.map(option => option.value);
	emit('change-option', options);
}
</script>

<template>
	<select ref="input"
		class="xgb-input"
		multiple
		@change="update()"
	>
		<slot />
	</select>
</template>
