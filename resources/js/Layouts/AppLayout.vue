<script setup lang="ts">
import { computed, reactive } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ThemeHandler } from '@/Classes/ThemeHandler';
import Breadcrumbs from '@/Components/Container/Breadcrumbs.vue';
import Nav from '@/Templates/Navigation/Nav.vue';
import Footer from '@/Templates/Footer.vue';

interface Props {
	title: string,
	full?: boolean,
}

const page = usePage();

const props = withDefaults(defineProps<Props>(), {
	title: '',
	full: false,
});

const widthClass = reactive({
	'md:w-11/12 lg:w-10/12': !props.full,
	'w-full': props.full,
});
const marginTop = reactive({
	'my-8': !props.full,
});
const breadcrumbs : any = computed(() => page.props.breadcrumbs);


const themeHandler: ThemeHandler = ThemeHandler.getInstance();
themeHandler.load();
</script>


<template>
	<Head :title="title" />

	<div class="min-h-screen flex flex-col bg-slate-100 dark:bg-slate-900">
		<Nav />

		<!-- Conteúdo -->
		<div :class="[ 'h-full mx-auto mt-12', widthClass]">
			<header v-if="$slots.header">
				<slot name="header" />
			</header>
			<main :class="[ 'relative', marginTop ]">
				<template v-if="breadcrumbs?.length > 0">
					<Breadcrumbs class="mb-4" :items="breadcrumbs" />
				</template>
				<slot />
			</main>
		</div>

		<Footer />
	</div>
</template>
