<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ThemeHandler } from '@/Classes/ThemeHandler';
import Nav from '@/Components/Nav.vue';
import Footer from '@/Components/Footer.vue';

defineProps({
	title: String
});

const themeHandler = ThemeHandler.getInstance();

themeHandler.load();
</script>


<template>
	<Head :title="title" />

	<div class="h-screen flex flex-col bg-slate-100 dark:bg-slate-900">
		<Nav />

		<!-- Conteúdo -->
		<div class="w-10/12 h-full relative mx-auto">
			<header v-if="$slots.header">
				<slot name="header" />
			</header>
			<main class="h-full">
				<slot />
			</main>
		</div>

		<Footer />
	</div>
</template>
