<script setup lang="ts">
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { ThemeHandler } from '@/Classes/ThemeHandler';
import NavItem from '@/Components/Admin/NavItem.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import FooterCopyright from '@/Components/FooterCopyright.vue';
import LanguageButton from '@/Components/LanguageButton.vue';
import ThemeSwitcher from '@/Components/ThemeSwitcher.vue';
import Tooltip from '@/Components/Tooltip.vue';

defineProps<{
	title: string;
}>();

const toggleSideBar = ref<boolean>(!(window.innerWidth > 768));
const iconSize = computed<string>(() =>
	document.body.clientWidth < 1024 ? 'xl' : '2xl'
);
const navHoverClass: string = 'hover:text-blue-200 hover:cursor-pointer';
const themeHandler: ThemeHandler = ThemeHandler.getInstance();

themeHandler.load();
</script>

<template>
	<Head :title="title" />
	<div class="bg-slate-100 dark:bg-slate-900">
		<!-- Cabeçalho -->
		<header
			class="flex fixed w-full h-24 z-20 shadow-xl bg-gradient-to-r from-blue-500 via-blue-400 to-blue-600"
		>
			<div class="relative w-[72px] min-w-[72px] max-w-[72px] ml-8 overflow-hidden">
				<Link href="/">
					<ApplicationLogo class="absolute top-1" />
				</Link>
			</div>

			<div class="flex p-8 justify-between w-full text-blue-100">
				<div>
					<font-awesome-icon
						icon="bars"
						:size="iconSize"
						:class="navHoverClass"
						@click="toggleSideBar = !toggleSideBar"
					/>
				</div>
				<div class="flex gap-4">
					<Tooltip>
						<template #label>
							<a
								:href="($page.props.emailInboxUrl as string)"
								target="_blank"
							>
								<font-awesome-icon
									icon="envelope"
									:size="iconSize"
									:class="navHoverClass"
								/>
							</a>
						</template>
						{{ $t('nav.email_inbox') }}
					</Tooltip>
					<ThemeSwitcher :size="iconSize" />
				</div>
			</div>
		</header>

		<!-- Área principal-->
		<main class="flex min-h-screen pt-24">
			<nav
				class="px-2 w-60 shrink-0 bg-gradient-to-b from-75% z-10 from-blue-500 to-blue-400 text-blue-100"
				:class="{
					'w-auto hidden sm:block': toggleSideBar,
					'fixed lg:static min-h-full': !toggleSideBar,
				}"
			>
				<menu class="mt-4">
					<li v-for="nav of $page.props.navLinks" class="mb-2">
						<NavItem :nav="nav" :no-label="toggleSideBar" />
					</li>
				</menu>
			</nav>
			<section class="w-full grow flex flex-col">
				<!-- Cabeçalho da página -->
				<header class="px-8 py-4 shadow-md bg-gray-200 dark:bg-slate-700">
					<h1 class="text-2xl mb-2 text-orange-400">{{ title }}</h1>
					<Breadcrumbs :items="($page.props.breadcrumbs as string[])" />
				</header>

				<!-- Corpo -->
				<article class="px-8 py-4 mt-4">
					<slot />
				</article>

				<!-- Rodapé -->
				<footer
					class="flex flex-col sm:flex-row gap-2 justify-between mt-auto px-8 py-4 w-full shadow-sm bg-blue-500"
				>
					<div class="self-end sm:self-start">
						<LanguageButton />
					</div>
					<FooterCopyright class="text-blue-100 text-right" />
				</footer>
			</section>
		</main>
	</div>
</template>
