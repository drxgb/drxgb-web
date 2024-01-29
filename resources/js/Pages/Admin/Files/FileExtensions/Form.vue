<script setup>
import { useForm, router } from '@inertiajs/vue3';
import AdminFormLayout from '@/Layouts/AdminFormLayout.vue';
import Card from '@/Components/Card.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import UploadInput from '@/Components/UploadInput.vue';

const props = defineProps({
	fileExtension: Object,
});

const form = useForm({
	id: null,
	name: props.fileExtension?.name,
	extension: props.fileExtension?.extension,
	icon: null,
});


function updateIcon(icons) {
	if (icons?.length > 0)
		form.icon = icons[0];
	else
		form.icon = null;
}


function submit(isUpdate) {
	if (isUpdate) {
		router.post(route('admin.file-extensions.update', props.fileExtension.id), {
			_method: 'put',
			forceFormData: true,
			id: form.id,
			name: form.name,
			extension: form.extension,
			icon: form.icon,
		});
	} else {
		form.post(route('admin.file-extensions.store'));
	}
}
</script>

<template>
	<AdminFormLayout
		:content="fileExtension"
		:form="form"
		label="File extension"
		@form-submit="submit"
	>
		<Card size="full" no-padding>
			<div class="px-8 py-4">
				<div class="flex flex-col sm:flex-row gap-4 w-full mb-4">
					<div class="w-full sm:w-1/6">
						<!-- Extensão -->
						<InputLabel for="extension" :value="$t('Extension')" required />
						<TextInput
							id="extension"
							class="w-full"
							v-model="form.extension"
							autofocus
						/>
						<InputError :message="form.errors?.extension" />
					</div>
					<div class="w-full sm:w-5/6">
						<!-- Nome -->
						<InputLabel for="name" :value="$t('Name')" required />
						<TextInput
							id="name"
							class="w-full"
							v-model="form.name"
							autofocus
						/>
						<InputError :message="form.errors?.name" />
					</div>
				</div>

				<div class="mb-4">
					<!-- Ícone -->
					<InputLabel for="icon" :value="$t('Icon')" />
					<UploadInput
							id="icon"
							ref="uploadInput"
							accept="image/png, image/bmp, image/gif"
							label="Choose icon"
							:initial-files="fileExtension?.icon_path ? fileExtension.icon : null"
							@update="updateIcon"
						/>
					<InputError :message="form.errors?.icon" class="mt-2" />
				</div>
			</div>
		</Card>
	</AdminFormLayout>
</template>
