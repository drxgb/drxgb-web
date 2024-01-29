<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DataListLayout from '@/Layouts/DataListLayout.vue';
import DataColumn from '@/Classes/Layouts/DataColumn';

defineProps<{
	products: any,
}>();

const columns: DataColumn[] = [
	new DataColumn('Name', 'name'),
	new DataColumn('Category', categoryName, 'w-1/4 hidden md:table-cell'),
	new DataColumn('Price', 'price'),
	new DataColumn('Active', activeIcon, 'w-2'),
];


function categoryName(product: any): any {
	return product.category.name;
}


function activeIcon(product: any): any {
	return product.active
		? '<font-awesome-icon icon="check" size="xl" />'
		: null;
}
</script>

<template>
	<AdminLayout :title="$t('Products')">
		<DataListLayout
			title="Product"
			context="admin.products"
			:content="products"
			:columns="columns"
			:viewable="false"
		/>
	</AdminLayout>
</template>
