<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DataListLayout from '@/Layouts/DataListLayout.vue';
import DataColumn from '@/Classes/Layouts/DataColumn';
import type Product from '@/Classes/Models/Product';

defineProps<{
	products: any,
}>();

const columns: DataColumn[] = [
	new DataColumn('Name', 'title'),
	new DataColumn('Category', categoryName, 'w-1/4 hidden md:table-cell'),
	new DataColumn('Price', 'price'),
	new DataColumn('Active', activeIcon, 'w-2'),
];


function categoryName(product : Product) : string
{
	return product.related_category?.name;
}


function activeIcon(product : Product) : string|null
{
	return product.active
		? '<img src="/img/icon/check.png" />'
		: null;
}
</script>

<template>
	<AdminLayout :title="$t('Products')">
		<DataListLayout title="Product"
			context="admin.products"
			name-key="title"
			:content="products"
			:columns="columns"
			:viewable="false"
		/>
	</AdminLayout>
</template>
