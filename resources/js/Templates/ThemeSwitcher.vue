<script setup lang="ts">
import { ref, computed } from 'vue';
import { ThemeHandler } from '@/Classes/ThemeHandler';
import { trans as __ } from 'laravel-vue-i18n';
import Tooltip from '@/Components/Container/Tooltip.vue';

defineProps({
	size: {
		type: String,
		default: '',
	}
});

const handler = ThemeHandler.getInstance();
const theme = ref(handler.getTheme());

const toggleTheme = () =>
{
	const value = theme.value === 'light' ? 'dark' : 'light';

	theme.value = value;
	handler.setTheme(value);
};
const themeIcon = computed(() => theme.value === 'light' ? 'sun' : 'moon');
const themeName = computed(() => __(`theme.${theme.value}`));
</script>


<template>
	<div class="w-[12px] flex justify-center">
		<Tooltip>
			<template #label>
				<font-awesome-icon :icon="themeIcon"
					@click="toggleTheme()"
					:size="size"
					class="text-green-200 hover:cursor-pointer"
				/>
			</template>

			{{ themeName }}
		</Tooltip>
	</div>
</template>
