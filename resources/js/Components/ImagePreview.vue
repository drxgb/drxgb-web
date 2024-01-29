<script setup>
import { ref } from 'vue';
import RadioButton from '@/Components/RadioButton.vue';

const props = defineProps({
	preview: String,
	select: {
		type: Boolean,
		default: false,
	},
	index: {
		default: null,
	},
});

defineEmits([ 'remove' ]);

const selected = defineModel();
const hidden = ref(true);
const radio = ref(null);


function selectImage() {
	if (props.select && radio.value) {
		radio.value.click();
		radio.value.focus();
	}
}
</script>

<template>
	<div class="relative" @mouseenter="hidden = false" @mouseleave="hidden = true">
		<img
			:src="preview"
			:alt="$t('Preview')"
			@click="selectImage"
		/>
		<RadioButton
			v-if="select"
			ref="radio"
			class="absolute top-2 left-2 shadow-sm"
			color="success"
			:value="index"
			v-model="selected"
		/>
		<font-awesome-icon
			class="absolute top-1 right-1 text-red-500 shadow-sm hover:cursor-pointer"
			:class="{ hidden }"
			icon="trash"
			size="sm"
			@click="$emit('remove')"
		/>
	</div>
</template>
