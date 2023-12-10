<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
</script>

<template>
	<AdminLayout :title="$t('nav.admin_dashboard')">
		<template #header>
			Cabeçalho
		</template>

		Conteúdo
	</AdminLayout>
</template>
