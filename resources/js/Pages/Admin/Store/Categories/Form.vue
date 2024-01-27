<script setup>
import { useForm, router } from '@inertiajs/vue3';
import AdminFormLayout from '@/Layouts/AdminFormLayout.vue';
import Card from '@/Components/Card.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';

const props = defineProps({
	category: Object,
	categories: Array,
});
const form = useForm({
	name: props.category?.name,
	parent_id: props.category?.parent_id,
});


function submit(isUpdate) {
	if (isUpdate) {
		form.put(route('admin.categories.update', props.category.id));
	} else {
		form.post(route('admin.categories.store'));
	}
}
</script>

<template>
	<AdminFormLayout
			:content="category"
			:form="form"
			label="Category"
			@form-submit="submit"
		>
		<Card size="full" no-padding>
			<div class="px-8 py-4">
				<InputLabel for="name" :value="$t('Name')" required />
				<TextInput
					id="name"
					class="w-full"
					v-model="form.name"
					autofocus
				/>
				<InputError :message="form.errors?.name" class="mt-2" />

				<InputLabel class="mt-4" for="parent-id" :value="$t('Parent category')" required />
				<SelectInput
					id="parent-id"
					class="w-full"
					v-model="form.parent_id"
				>
					<option value="">({{ $t('None') }})</option>
					<option v-for="parent in categories" :value="parent.id">
						{{ '&nbsp;'.repeat(4 * parent.depth) }}
						{{ parent.depth > 0 ? '--' : '' }}
						{{ parent.name }}
					</option>
				</SelectInput>
			</div>
		</Card>
	</AdminFormLayout>
</template>
