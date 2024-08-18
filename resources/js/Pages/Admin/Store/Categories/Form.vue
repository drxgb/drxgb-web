<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminFormLayout from '@/Layouts/AdminFormLayout.vue';
import Card from '@/Components/Card/Card.vue';
import CategorySelectInput from '@/Components/Admin/CategorySelectInput.vue';
import InputLabel from '@/Components/Input/InputLabel.vue';
import InputError from '@/Components/Input/InputError.vue';
import TextInput from '@/Components/Input/TextInput.vue';

const props = defineProps({
	category: Object,
	categories: Array,
});
const form = useForm({
	name: props.category?.name,
	parent_id: props.category?.parent_id,
});


function submit(isUpdate)
{
	if (isUpdate)
	{
		form.put(route('admin.categories.update', props.category.id));
	}
	else
	{
		form.post(route('admin.categories.store'));
	}
}
</script>

<template>
	<AdminFormLayout :content="category"
		:form="form"
		label="Category"
		@form-submit="submit"
	>
		<Card size="full" no-padding>
			<div class="px-8 py-4">
				<InputLabel for="name" :value="$t('Name')" required />
				<TextInput v-model="form.name"
					id="name"
					class="w-full"
					autofocus
				/>
				<InputError :message="form.errors?.name" class="mt-2" />

				<InputLabel class="mt-4" for="parent-id" :value="$t('Parent category')" required />
				<CategorySelectInput v-model="form.parent_id"
					id="parent-id"
					class="w-full"
					:categories="categories"
				/>
			</div>
		</Card>
	</AdminFormLayout>
</template>
