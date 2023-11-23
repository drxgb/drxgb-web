<script setup lang="ts">
import { computed } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import Button from './Button.vue';

defineProps({
	color: {
		type: String,
		default: 'primary'
	},
});

const page = usePage();
const language = page.props.language;
</script>


<template>
	<Button :color="color">
		<span class="flex items-baseline">
			<img :src="`/img/flags/${language.country_flag}.gif`" :alt="language.country_flag" />
			<span class="mx-2">{{ language.name }}</span>
			<font-awesome-icon :icon="['fas', 'angle-right']" />
		</span>
	</Button>
</template>
