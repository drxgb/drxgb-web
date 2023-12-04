<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ThemeHandler } from '@/Classes/ThemeHandler';
import Nav from '@/Components/Nav.vue';
import Footer from '@/Components/Footer.vue';

defineProps({
	title: String
});

const themeHandler: ThemeHandler = ThemeHandler.getInstance();
themeHandler.load();
</script>


<template>
	<Head :title="title" />

	<div class="min-h-screen flex flex-col bg-slate-100 dark:bg-slate-900">
		<Nav />

		<!-- Conteúdo -->
		<div class="h-full md:w-11/12 lg:w-10/12 mx-auto">
			<header v-if="$slots.header">
				<slot name="header" />
			</header>
			<main class="relative my-8">
				<slot />
			</main>
		</div>

		<Footer />
	</div>
</template>
