<script setup lang="ts">
import { reactive } from 'vue';
import { Head } from '@inertiajs/vue3';
import { ThemeHandler } from '@/Classes/ThemeHandler';
import Nav from '@/Components/Nav.vue';
import Footer from '@/Components/Footer.vue';

interface Props {
	title: string,
	full?: boolean
}

const props = withDefaults(defineProps<Props>(), {
	title: '',
	full: false,
});

const widthClass = reactive<string>({
	'md:w-11/12 lg:w-10/12': !props.full,
	'w-full': props.full,
});
const marginTop = reactive<string>({
	'my-8': !props.full,
});

const themeHandler: ThemeHandler = ThemeHandler.getInstance();
themeHandler.load();
</script>


<template>
	<Head :title="title" />

	<div class="min-h-screen flex flex-col bg-slate-100 dark:bg-slate-900">
		<Nav />

		<!-- Conteúdo -->
		<div :class="['h-full mx-auto', widthClass]">
			<header v-if="$slots.header">
				<slot name="header" />
			</header>
			<main :class="['relative', marginTop]">
				<slot />
			</main>
		</div>

		<Footer />
	</div>
</template>
