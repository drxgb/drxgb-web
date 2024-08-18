<script setup>
import { computed } from 'vue';

defineProps({
	value: String,
	required: {
		type: Boolean,
		default: false,
	},
});

const requireSymbol = computed(() => '<span class="text-red-500 text-xs">*</span>');
</script>

<template>
    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">
        <span v-if="value">
			{{ value }}
			<span v-if="required" v-html="requireSymbol" />
		</span>
        <span v-else>
			<slot />
			<span v-if="required" v-html="requireSymbol" />
		</span>
    </label>
</template>
