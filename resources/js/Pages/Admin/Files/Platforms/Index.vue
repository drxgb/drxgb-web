<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DataListLayout from '@/Layouts/DataListLayout.vue';
import DataColumn from '@/Classes/Layouts/DataColumn';

const props = defineProps<{
	platforms: any,
}>();

const columns: DataColumn[] = [
	new DataColumn('Icon', iconCell, 'w-2'),
	new DataColumn('Short name', 'short_name', 'w-32'),
	new DataColumn('Name', 'name', 'hidden md:table-cell'),
];


function iconCell(platform: DataColumn): string {
	return `<img src="${platform.icon}" alt="${platform.name}" class="mx-auto" />`;
}
</script>

<template>
	<AdminLayout :title="$t('Platforms')">
		<DataListLayout
			title="Platform"
			context="admin.platforms"
			:content="platforms"
			:columns="columns"
			:viewable="false"
		/>
	</AdminLayout>
</template>
