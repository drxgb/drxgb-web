<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Button from '@/Components/Input/Button.vue';
import ListCell from '@/Components/Container/ListCell.vue';
import Modal from '@/Components/Modal/Modal.vue';

defineProps({
	categories: Object,
});

const form = useForm({});
const confirmDeletion = ref(false);
const categoryItem = ref(null);


function openDeleteModal(category)
{
	categoryItem.value = category;
	confirmDeletion.value = true;
}


function closeDeleteModal()
{
	categoryItem.value = null;
	confirmDeletion.value = false;
}


function deleteCategory(category)
{
	form.delete(route('admin.categories.destroy', category.id), {
		preserveScroll: true,
		onSuccess: () => closeDeleteModal(),
	});
}
</script>

<template>
	<AdminLayout :title="$t('Categories')">
		<div class="flex flex-row-reverse my-4">
			<Button type="button" color="primary" icon="plus" :href="(route('admin.categories.create'))">
				{{ $t('Create') }} {{ $t('Category') }}
			</Button>
		</div>

		<section class="w-full my-4 border-2 rounded-md border-sky-500">
			<ListCell v-for="category in categories"
				class="px-6 flex justify-between border-sky-200 bg-sky-50 text-sky-400 odd:bg-sky-100 dark:border-sky-500 dark:bg-sky-600 dark:text-sky-50 dark:odd:bg-sky-500"
			>
				<span :href="route('admin.categories.edit', category.id)"
					:style="`padding-left: ${24 * category.depth}px;`"
				>
					{{ category.depth > 0 ? '--' : '' }}
					{{ category.name }}
				</span>

				<div class="flex gap-x-1">
					<Button
						type="button"
						color="warning"
						icon="edit"
						:href="route('admin.categories.edit', category.id)"
					/>
					<Button icon="trash"
						color="danger"
						@click="openDeleteModal(category)"
					/>
				</div>
			</ListCell>
		</section>
	</AdminLayout>

	<Modal v-if="categoryItem"
		type="warning"
		:show="confirmDeletion"
		@close="closeDeleteModal()"
	>
		<template #header>
			{{ $t('Delete') }} {{ $t(categoryItem.name) }}
		</template>

		<div class="px-8 py-4">
			<p>
				{{ $t('Are you sure to delete') }}
				<strong>{{ $t(categoryItem.name) }}</strong>?
			</p>
			<p>
				{{ $t('This action is irreversible') }}.
				{{ $t('All its subcategories will also be deleted.') }}
			</p>
			<p class="my-4">
				{{ $t('Confirm exclusion') }}?
			</p>
		</div>

		<template #footer>
			<form @submit="deleteCategory(categoryItem)">
				<Button color="danger" icon="trash" class="w-32">
					{{ $t('Yes') }}
				</Button>
			</form>
			<Button color="secondary" icon="times" class="w-32" @click.prevent="closeDeleteModal()">
				{{ $t('No') }}
			</Button>
		</template>
	</Modal>
</template>
