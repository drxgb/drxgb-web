<script setup lang="ts">
import { ref, computed } from 'vue';
import { ThemeHandler } from '@/Classes/ThemeHandler';
import { trans } from 'laravel-vue-i18n';

defineProps({
	size: {
		type: String,
		default: '',
	}
});

const handler = ThemeHandler.getInstance();
const theme = ref(handler.getTheme());

const toggleTheme = () => {
	const value = theme.value === 'light' ? 'dark' : 'light';

	theme.value = value;
	handler.setTheme(value);
};
const themeIcon = computed(() => theme.value === 'light' ? 'sun' : 'moon');
const themeName = computed(() => trans(`theme.${theme.value}`));
</script>


<template>
	<div class="w-[12px] flex justify-center">
		<font-awesome-icon
			@click="toggleTheme()"
			:icon="themeIcon"
			:size="size"
			:title="themeName"
			class="text-green-200 hover:cursor-pointer" />
	</div>
</template>
