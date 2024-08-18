<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DataListLayout from '@/Layouts/DataListLayout.vue';
import DataColumn from '@/Classes/Layouts/DataColumn';
import type FileExtension from '@/Classes/Models/FileExtension';

defineProps<{
	extensions: any,
}>();

const columns: DataColumn[] = [
	new DataColumn('Icon', iconCell, 'w-2'),
	new DataColumn('Extension', 'extension', 'w-2'),
	new DataColumn('Name', 'name', 'hidden md:table-cell'),
];


function iconCell(extension : FileExtension) : string
{
	return `<img src="${extension.icon}" alt="${extension.name}" class="mx-auto" />`;
}
</script>

<template>
	<AdminLayout :title="$t('File extensions')">
		<DataListLayout title="File extension"
			context="admin.file-extensions"
			:content="extensions"
			:columns="columns"
			:viewable="false"
		/>
	</AdminLayout>
</template>
