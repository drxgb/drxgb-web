<script setup>
import { ref } from 'vue';

defineProps({
	preview: String,
});

defineEmits([ 'remove' ]);

const hidden = ref(true);
</script>

<template>
	<div class="relative" @mouseenter="hidden = false" @mouseleave="hidden = true">
		<img
			:src="preview"
			:alt="$t('Preview')"
			class="max-w-8"
		/>
		<font-awesome-icon
			class="absolute top-0 right-0 hover:cursor-pointer"
			:class="{ hidden }"
			icon="trash"
			size="sm"
			@click="$emit('remove')"
		/>
	</div>
</template>
