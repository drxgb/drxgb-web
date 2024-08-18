<script setup>
import SelectInput from '@/Components/Input/SelectInput.vue';

defineProps({
	categories: Array,
});

const model = defineModel();
</script>

<template>
	<SelectInput
		v-model="model"
	>
		<option value="">({{ $t('None') }})</option>
		<option v-for="category in categories" :value="category.id">
			{{ '&nbsp;'.repeat(4 * category.depth) }}
			{{ category.depth > 0 ? '--' : '' }}
			{{ category.name }}
		</option>
	</SelectInput>
</template>
