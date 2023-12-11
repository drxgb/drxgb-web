<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Hero from './Partials/Hero.vue';
import Partners from './Partials/Partners.vue';
</script>

<template>
	<AppLayout :title="$t('page.home')" full>
		<Hero />
		<Partners />
	</AppLayout>
</template>
