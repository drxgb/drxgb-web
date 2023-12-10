<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ThemeHandler } from '@/Classes/ThemeHandler';
import NavItem from '@/Components/Admin/NavItem.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';

defineProps<{
	title: string,
}>();

const reducedSideBar = ref<boolean>(false);
const navHoverClass: string = 'hover:text-blue-200 hover:cursor-pointer';
const themeHandler: ThemeHandler = ThemeHandler.getInstance();

themeHandler.load();
</script>


<template>
	<Head :title="title" />
	<div class="bg-slate-100 dark:bg-slate-900">
		<!-- Cabeçalho -->
		<header class="flex fixed w-full h-24 z-10 p-8 shadow-xl overflow-hidden bg-gradient-to-r from-blue-500 via-blue-400 to-blue-600">
			<div>
				<Link href="/">
					<ApplicationLogo class="absolute top-1" />
				</Link>
			</div>

			<div class="ml-24 text-blue-100">
				<font-awesome-icon
					icon="bars"
					size="2xl"
					:class="navHoverClass"
					@click="reducedSideBar = !reducedSideBar" />
			</div>
		</header>

		<!-- Área principal-->
		<main class="flex min-h-screen h-full pt-24">
			<nav
				class="px-2 w-60 shrink-0 bg-gradient-to-b from-75% from-blue-500 to-blue-400 text-blue-100"
				:class="{ 'w-auto': reducedSideBar }">
				<menu class="mt-4">
					<li	v-for="nav of $page.props.navLinks" class="mb-2">
						<NavItem :nav="nav" :no-label="reducedSideBar" />
					</li>
				</menu>
			</nav>
			<section class="w-full grow flex flex-col">
				<!-- Cabeçalho da página -->
				<header class="px-8 py-4 shadow-md dark:bg-slate-700">
					<h1 class="text-2xl mb-2 text-orange-400">{{ title }}</h1>
					<Breadcrumbs :items="$page.props.breadcrumbs" />
				</header>

				<!-- Corpo -->
				<article class="px-8 py-4 mt-4">
					<slot />
				</article>

				<!-- Rodapé -->
				<footer class="mt-auto px-8 py-4 w-full text-right shadow-sm bg-blue-500">
					&copy;
					{{ new Date().getFullYear() }} -
					{{ $t('footer.made_by_drxgb') }}
				</footer>
			</section>
		</main>
	</div>
</template>
